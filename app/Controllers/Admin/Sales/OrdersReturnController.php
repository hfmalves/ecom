<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerGroupModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersReturnItemsModel;
use App\Models\Admin\Sales\OrdersReturnsModel;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersReturnController extends BaseController
{
    protected $returnsModel;
    protected $returnItemsModel;
    protected $ordersModel;
    protected $ordersItemsModel;
    protected $customerModel;
    protected $customerGroupModel;
    protected $customerAddressModel;
    protected $productsModel;
    protected $productsVariantsModel;

    public function __construct()
    {
        $this->returnsModel      = new OrdersReturnsModel();
        $this->returnItemsModel  = new OrdersReturnItemsModel();
        $this->ordersModel       = new OrdersModel();
        $this->ordersItemsModel  = new OrdersItemsModel();
        $this->customerModel     = new CustomerModel();
        $this->customerGroupModel = new CustomerGroupModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->productsModel = new ProductsModel();
        $this->productsVariantsModel = new ProductsVariantsModel();
    }
    public function index()
    {
        $returns      = $this->returnsModel->findAll();
        $orders       = $this->ordersModel->findAll();
        $customers    = array_column($this->customerModel->findAll(), null, 'id');
        $returnItems  = $this->returnItemsModel->findAll();
        $mapReturnItems = [];
        foreach ($returnItems as $ri) {
            $mapReturnItems[$ri['rma_request_id']][] = $ri;
        }
        foreach ($orders as &$o) {
            $o['customer'] = $customers[$o['customer_id']] ?? [
                'name'  => '—',
                'email' => '',
            ];
        }
        unset($o);
        foreach ($returns as &$r) {
            $r['order']    = $orders[$r['order_id']] ?? null;
            $r['customer'] = $customers[$r['customer_id']] ?? null;
            $r['items']    = $mapReturnItems[$r['id']] ?? [];
        }
        unset($r);
        return view('admin/sales/returns/index', [
            'returns'   => $returns,
            'orders'    => $orders,
            'customers' => $customers,
        ]);
    }
    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Método inválido');
        }
        $data = $this->request->getJSON(true);
        if (empty($data['order_id']) || empty($data['resolution']) || empty($data['reason'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Campos obrigatórios em falta.'
            ]);
        }
        $order = $this->ordersModel->find($data['order_id']);
        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Encomenda não encontrada.'
            ]);
        }
        $returnData = [
            'order_id'     => (int) $data['order_id'],
            'customer_id'  => (int) ($order['customer_id'] ?? 0),
            'reason'       => trim($data['reason']),
            'resolution'   => $data['resolution'],
            'status'       => 'pending',
            'refund_amount'=> 0.00,
            'notes'        => $data['notes'] ?? null,
            'created_at'   => date('Y-m-d H:i:s'),
            'handled_by'   => session('user.id') ?? null,
        ];
        if (!$this->returnsModel->insert($returnData)) {
            log_message('error', 'Erro ao criar RMA: ' . print_r($this->returnsModel->errors(), true));
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao criar RMA.',
                'errors'  => $this->returnsModel->errors()
            ]);
        }
        $rmaId = $this->returnsModel->getInsertID();
        $rmaNumber = 'RMA-' . str_pad($rmaId, 5, '0', STR_PAD_LEFT);
        $this->returnsModel->update($rmaId, ['rma_number' => $rmaNumber]);
        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => 'RMA criada com sucesso.',
            'rma_id'     => $rmaId,
            'rma_number' => $rmaNumber,
            'redirect'   => base_url('admin/sales/returns/edit/' . $rmaId)
        ]);

    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Devolução não encontrada.');
        }

        // Buscar RMA
        $return = $this->returnsModel->find($id);
        if (!$return) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("RMA #$id não encontrada.");
        }

        // Buscar encomenda associada
        $order = $this->ordersModel->find($return['order_id']);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Encomenda associada à RMA #$id não encontrada.");
        }

        // Buscar cliente
        $customer = $this->customerModel->find($order['customer_id']);
        if ($customer) {
            $groupName = '-';
            if (!empty($customer['group_id']) && property_exists($this, 'customerGroupModel')) {
                $group = $this->customerGroupModel->find($customer['group_id']);
                $groupName = $group['name'] ?? '-';
            }
            $customer['group_name'] = $groupName;
        }

        // Buscar itens da encomenda original
        $orderItems = $this->ordersItemsModel
            ->where('order_id', $order['id'])
            ->findAll();

        foreach ($orderItems as &$item) {
            $product = $this->productsModel->find($item['product_id']);
            $item['product_name'] = $product['name'] ?? ('Produto #' . $item['product_id']);
            $item['sku'] = $product['sku'] ?? '-';

            if (!empty($item['variant_id'])) {
                $variant = $this->productsVariantsModel->find($item['variant_id']);
                $item['variant_name'] = $variant['sku'] ?? ('Variante #' . $item['variant_id']);
            } else {
                $item['variant_name'] = '-';
            }

            // 🔹 Corrigir valor base de reembolso
            $item['refund_amount'] = ($item['price'] ?? 0)
                + ($item['tax_amount'] ?? 0)
                - ($item['discount_amount'] ?? 0);

            // 🔹 Total com base na quantidade encomendada (ou devolvida)
            $item['refund_total'] = ($item['refund_amount'] * ($item['qty_returned'] ?? $item['qty'] ?? 1));
        }
        unset($item);
        $returnItems = $this->returnItemsModel
            ->where('rma_request_id', $return['id'])
            ->findAll();
        $returnedItems = [];
        $availableItems = [];
        $groupedReturns = [];
        foreach ($returnItems as $r) {
            $oid = $r['order_item_id'];
            if (!isset($groupedReturns[$oid])) {
                $groupedReturns[$oid] = [
                    'qty_returned' => 0,
                    'refund_total' => 0,
                    'condition' => $r['condition'] ?? 'new',
                    'restocked_qty' => (int)($r['restocked_qty'] ?? 0),
                ];
            }
            $groupedReturns[$oid]['qty_returned'] += (int)$r['qty_returned'];
            $groupedReturns[$oid]['refund_total'] += (float)$r['refund_amount'];
        }
        foreach ($orderItems as $k => $item) {
            $oid = $item['id'];
            $qtyOrdered = (int)($item['qty'] ?? 0);
            $returnData = $groupedReturns[$oid] ?? null;

            $qtyReturned  = (int)($returnData['qty_returned'] ?? 0);
            $qtyAvailable = max($qtyOrdered - $qtyReturned, 0);

            $orderItems[$k]['qty_ordered']   = $qtyOrdered;
            $orderItems[$k]['qty_returned']  = $qtyReturned;
            $orderItems[$k]['qty_available'] = $qtyAvailable;
            $orderItems[$k]['refund_amount'] = (float)($returnData['refund_total'] ?? 0.00);
            $orderItems[$k]['condition']     = $returnData['condition'] ?? 'new';
            $orderItems[$k]['restocked_qty'] = $returnData['restocked_qty'] ?? 0;
            $orderItems[$k]['return_status'] = $qtyReturned > 0 ? 'requested' : 'none';

            // Distribui entre listas
            if ($qtyReturned > 0) {
                $returnedItems[] = $orderItems[$k];
            }
            if ($qtyAvailable > 0) {
                $availableItems[] = $orderItems[$k];
            }
        }

        unset($item);

        // 🔹 Itens devolvidos e disponíveis
        $returnedItems = [];
        $availableItems = [];

        foreach ($orderItems as $item) {
            $qtyOrdered   = (int)($item['qty_ordered'] ?? $item['qty'] ?? 0);
            $qtyReturned  = (int)($item['qty_returned'] ?? 0);
            $qtyAvailable = max($qtyOrdered - $qtyReturned, 0);

            // Se tem devoluções, entra em returnedItems
            if ($qtyReturned > 0) {
                $returnedItems[] = $item;
            }

            // Se ainda resta stock, também entra em availableItems
            if ($qtyAvailable > 0) {
                $item['qty_available'] = $qtyAvailable;
                $availableItems[] = $item;
            }
        }

        // Histórico da RMA
        $history = [];
        if (property_exists($this, 'returnsHistoryModel')) {
            $history = $this->returnsHistoryModel
                ->where('rma_request_id', $id)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        // Estados disponíveis
        $statuses = [
            'requested' => 'Pedido',
            'approved'  => 'Aprovado',
            'rejected'  => 'Rejeitado',
            'refunded'  => 'Reembolsado',
            'completed' => 'Concluído',
        ];
        // --- Renderizar a View ---
        return view('admin/sales/returns/edit', [
            'return'        => $return,
            'order'         => $order,
            'customer'      => $customer,
            'items'         => $orderItems,
            'returnItems'   => $returnItems,
            'availableItems'=> $availableItems,
            'returnedItems' => $returnedItems,
            'statuses'      => $statuses,
            'history'       => $history,
        ]);
    }
    public function saveItems()
    {
        // pegar JSON e logar (error) logo de inicio para visibilidade
        $json = $this->request->getJSON(true);
        log_message('error', '[RMA][saveItems] JSON recebido: ' . json_encode($json));

        $rmaId = $json['rma_id'] ?? null;
        $items = $json['items'] ?? [];

        if (!$rmaId || empty($items)) {
            log_message('error', "[RMA][saveItems] Dados inválidos. rma_id: " . var_export($rmaId, true) . " items_count: " . count($items));
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos.'
            ]);
        }

        $failed = [];
        $inserted = [];

        foreach ($items as $item) {
            // normalizar / garantir tipos
            $data = [
                'rma_request_id' => (int) $rmaId,
                'order_item_id'  => (int) ($item['id'] ?? 0),
                'qty_returned'   => (int) ($item['qty_returned'] ?? 0),
                'refund_amount'  => (float) ($item['refund_amount'] ?? 0),
                'condition'      => $item['condition'] ?? 'new',
                'restocked_qty'  => (!empty($item['restocked_qty']) && $item['restocked_qty']) ? 1 : 0,
                'status'         => 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
            ];

            // validação mínima antes de tentar inserir
            if ($data['order_item_id'] <= 0) {
                log_message('error', "[RMA][saveItems] Ignorado item com order_item_id inválido: " . json_encode($data));
                $failed[] = ['item' => $item, 'error' => 'order_item_id_invalido'];
                continue;
            }

            $ok = $this->returnItemsModel->insert($data);

            if ($ok === false) {
                // log de erro com detalhes do Model
                $modelErrors = $this->returnItemsModel->errors();
                log_message('error', "[RMA][saveItems] Erro ao inserir item: " . json_encode($data) . " | model_errors: " . json_encode($modelErrors));
                $failed[] = ['item' => $item, 'error' => $modelErrors];
            } else {
                $insertId = $this->returnItemsModel->getInsertID();
                log_message('error', "[RMA][saveItems] Inserido item_id={$insertId} para order_item_id={$data['order_item_id']} (rma={$rmaId})");
                $inserted[] = $insertId;
            }
        }

        // resumo final
        if (!empty($failed)) {
            log_message('error', "[RMA][saveItems] Inserções falharam: " . json_encode($failed));
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Alguns itens não foram gravados. Ver logs para detalhe.',
                'failed'  => $failed,
                'inserted'=> $inserted
            ]);
        }

        log_message('error', "[RMA][saveItems] Todos os itens inseridos com sucesso. inserted_ids: " . json_encode($inserted));

        return $this->response->setJSON([
            'status' => 'success',
            'message'=> 'Itens guardados com sucesso.',
            'inserted' => $inserted
        ]);
    }
    public function removeItems()
    {
        $json = $this->request->getJSON(true);
        $rmaId = $json['rma_id'] ?? null;
        $items = $json['items'] ?? [];
        if (!$rmaId || empty($items)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos.'
            ]);
        }
        foreach ($items as $item) {
            $this->returnItemsModel
                ->where('rma_request_id', $rmaId)
                ->where('order_item_id', $item['id'])
                ->delete();
        }
        return $this->response->setJSON(['status' => 'success']);
    }

}
