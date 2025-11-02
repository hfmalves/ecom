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
use App\Models\Admin\Sales\OrdersReturnsHistoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersReturnController extends BaseController
{
    protected $returnsModel;
    protected $returnItemsModel;
    protected $ordersModel;
    protected $ordersReturnsHistoryModel;
    protected $ordersItemsModel;
    protected $customerModel;
    protected $customerGroupModel;
    protected $customerAddressModel;
    protected $productsModel;
    protected $productsVariantsModel;

    public function __construct()
    {
        $this->returnsModel      = new OrdersReturnsModel();
        $this->ordersReturnsHistoryModel = new OrdersReturnsHistoryModel();
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
        $kpi = [
            // Devoluções
            'total_returns'   => $this->returnsModel->countAllResults(),
            'approved'        => $this->returnsModel->where('status', 'approved')->countAllResults(true),
            'pending'         => $this->returnsModel->where('status', 'pending')->countAllResults(true),
            'rejected'        => $this->returnsModel->where('status', 'rejected')->countAllResults(true),
            'last_30_days'    => $this->returnsModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'avg_items'       => number_format(
                $this->returnItemsModel->selectAvg('qty_returned', 'avg')->first()['avg'] ?? 0,
                2,
                ',',
                ' '
            ),
            'total_restocked' => $this->returnItemsModel
                    ->where('restocked_qty >', 0)
                    ->selectSum('restocked_qty', 'sum')
                    ->first()['sum'] ?? 0,
            'total_refunded'  => number_format(
                $this->returnItemsModel->selectSum('refund_amount', 'sum')->first()['sum'] ?? 0,
                2,
                ',',
                ' '
            ),
            'new_condition'   => $this->returnItemsModel->where('condition', 'new')->countAllResults(true),
            'damaged_items'   => $this->returnItemsModel
                ->groupStart()
                ->where('condition', 'damaged')
                ->orWhere('condition', 'defective')
                ->groupEnd()
                ->countAllResults(true),
        ];


        return view('admin/sales/returns/index', [
            'returns'   => $returns,
            'orders'    => $orders,
            'customers' => $customers,
            'kpi'       => $kpi,
        ]);
    }
    public function store()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(405)->setJSON([
                'status'  => 'error',
                'message' => 'Método inválido.'
            ]);
        }
        $data = $this->request->getJSON(true);
        $order = $this->ordersModel->find($data['order_id'] ?? 0);
        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => ['order_id' => 'A encomenda é obrigatória']
            ]);
        }
        $returnData = [
            'order_id'     => (int) ($data['order_id'] ?? 0),
            'customer_id'  => (int) ($order['customer_id'] ?? 0),
            'reason'       => trim($data['reason'] ?? ''),
            'resolution'   => $data['resolution'] ?? '',
            'status'       => 'pending',
            'refund_amount'=> 0.00,
            'notes'        => trim($data['notes'] ?? ''),
            'created_at'   => date('Y-m-d H:i:s'),
            'handled_by'   => session('user.id') ?? null,
        ];
        if (!$this->returnsModel->insert($returnData)) {
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
        $return = $this->returnsModel->find($id);
        if (!$return) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("RMA #$id não encontrada.");
        }
        $order = $this->ordersModel->find($return['order_id']);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Encomenda associada à RMA #$id não encontrada.");
        }
        $customer = $this->customerModel->find($order['customer_id']);
        if ($customer) {
            $groupName = '-';
            if (!empty($customer['group_id']) && property_exists($this, 'customerGroupModel')) {
                $group = $this->customerGroupModel->find($customer['group_id']);
                $groupName = $group['name'] ?? '-';
            }
            $customer['group_name'] = $groupName;
        }
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
            $item['refund_amount'] = ($item['price'] ?? 0)
                + ($item['tax_amount'] ?? 0)
                - ($item['discount_amount'] ?? 0);
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
        $returnedItems = [];
        $availableItems = [];
        foreach ($orderItems as $item) {
            $qtyOrdered   = (int)($item['qty_ordered'] ?? $item['qty'] ?? 0);
            $qtyReturned  = (int)($item['qty_returned'] ?? 0);
            $qtyAvailable = max($qtyOrdered - $qtyReturned, 0);
            if ($qtyReturned > 0) {
                $returnedItems[] = $item;
            }
            if ($qtyAvailable > 0) {
                $item['qty_available'] = $qtyAvailable;
                $availableItems[] = $item;
            }
        }
        $history = $this->ordersReturnsHistoryModel
            ->where('rma_request_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $statuses = [
            'requested' => 'Pedido',
            'approved'  => 'Aprovado',
            'rejected'  => 'Rejeitado',
            'refunded'  => 'Reembolsado',
            'completed' => 'Concluído',
        ];

        if ($customer && !empty($customer['name'])) {
            $parts = explode(' ', trim($customer['name']));
            $customer['first_last'] = count($parts) > 1
                ? ($parts[0] . ' ' . end($parts))
                : $parts[0];
        }
        $return['customer'] = $customer;
        $return['history'] = $history;
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
    public function update()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(405)->setJSON([
                'status'  => 'error',
                'message' => 'Método inválido.'
            ]);
        }
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'ID em falta.'
            ]);
        }
        $id = (int)$data['id'];
        $return = $this->returnsModel->find($id);
        if (!$return) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Devolução não encontrada.'
            ]);
        }
        $updateData = [
            'id'           => $id,
            'status'       => $data['status'] ?? null,
            'notes'        => trim($data['notes'] ?? ''),
            'notify_client'=> !empty($data['notify_client']) ? 1 : 0,
            'handled_by'   => session('user.id') ?? null,
            'updated_at'   => date('Y-m-d H:i:s'),
        ];
        if (!$this->returnsModel->save($updateData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'errors' => $this->returnsModel->errors(),
            ]);
        }
        $this->ordersReturnsHistoryModel->insert([
            'rma_request_id' => $id,
            'order_id'       => $return['order_id'],
            'status'         => $updateData['status'],
            'order_status'   => $this->ordersModel->find($return['order_id'])['status'] ?? null,
            'reason'         => $return['reason'] ?? null,
            'notes'          => $updateData['notes'],
            'handled_by'     => session('user.id') ?? null,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'RMA atualizada com sucesso.',
        ]);
    }
    public function saveItems()
    {
        $json = $this->request->getJSON(true);
        $rmaId = (int)($json['rma_id'] ?? 0);
        $items = $json['items'] ?? [];

        if ($rmaId <= 0 || empty($items)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Dados inválidos.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // Buscar a devolução associada
        $return = $this->returnsModel->find($rmaId);
        if (!$return) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Devolução não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $failed   = [];
        $inserted = [];

        foreach ($items as $item) {
            $orderItemId  = (int)($item['id'] ?? 0);
            $qtyReturned  = (int)($item['qty_returned'] ?? 0);
            $refundAmount = (float)($item['refund_amount'] ?? 0);

            if ($orderItemId <= 0) {
                $failed[] = ['item' => $item, 'error' => 'order_item_id_invalido'];
                continue;
            }

            $data = [
                'rma_request_id' => $rmaId,
                'order_item_id'  => $orderItemId,
                'qty_returned'   => $qtyReturned,
                'refund_amount'  => $refundAmount,
                'condition'      => $item['condition'] ?? 'new',
                'restocked_qty'  => !empty($item['restocked_qty']) ? (int)$item['restocked_qty'] : 0,
                'status'         => 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
            ];

            if ($this->returnItemsModel->insert($data) === false) {
                $failed[] = [
                    'item'  => $item,
                    'error' => $this->returnItemsModel->errors() ?? 'Erro desconhecido',
                ];
            } else {
                $inserted[] = $this->returnItemsModel->getInsertID();
                // Histórico
                $this->ordersReturnsHistoryModel->insert([
                    'rma_request_id' => $rmaId,
                    'order_id'       => $return['order_id'],
                    'status'         => 'item_added',
                    'order_status'   => $this->ordersModel->find($return['order_id'])['status'] ?? null,
                    'reason'         => $return['reason'] ?? null,
                    'notes'          => 'Artigo devolvido: ' . ($item['name'] ?? 'N/D'),
                    'item_in_id'     => $orderItemId,
                    'qty_in'         => $qtyReturned,
                    'handled_by'     => session('user.id') ?? null,
                    'created_at'     => date('Y-m-d H:i:s'),
                ]);
            }
        }
        $status  = empty($failed) ? 'success' : 'error';
        $message = empty($failed)
            ? 'Itens guardados com sucesso.'
            : 'Alguns itens não foram gravados. Ver logs para detalhe.';
        return $this->response->setJSON([
            'status'   => $status,
            'message'  => $message,
            'inserted' => $inserted,
            'failed'   => $failed,
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function removeItems()
    {
        $json = $this->request->getJSON(true);
        $rmaId = (int)($json['rma_id'] ?? 0);
        $items = $json['items'] ?? [];

        if ($rmaId <= 0 || empty($items)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Dados inválidos.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // Buscar a devolução associada
        $return = $this->returnsModel->find($rmaId);
        if (!$return) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Devolução não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $removed = 0;

        foreach ($items as $item) {
            $orderItemId = (int)($item['id'] ?? 0);
            if ($orderItemId <= 0) {
                continue;
            }

            $removed += $this->returnItemsModel
                ->where('rma_request_id', $rmaId)
                ->where('order_item_id', $orderItemId)
                ->delete();

            // Guardar histórico
            $this->ordersReturnsHistoryModel->insert([
                'rma_request_id' => $rmaId,
                'order_id'       => $return['order_id'],
                'status'         => 'item_removed',
                'order_status'   => $this->ordersModel->find($return['order_id'])['status'] ?? null,
                'reason'         => $return['reason'] ?? null,
                'notes'          => 'Artigo removido da devolução: ' . ($item['name'] ?? 'N/D'),
                'item_out_id'    => $orderItemId,
                'qty_out'        => (int)($item['qty_returned'] ?? 1),
                'handled_by'     => session('user.id') ?? null,
                'created_at'     => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => $removed > 0
                ? 'Itens removidos com sucesso.'
                : 'Nenhum item foi removido.',
            'removed' => $removed,
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
