<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsPackItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductsPackItemController extends BaseController
{
    protected $packItems;

    public function __construct()
    {
        $this->packItems = new ProductsPackItemModel();
    }

    /**
     * Guarda (substitui todos os items do pack)
     */
    public function savePackItems($productId = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }

        $data = $this->request->getJSON(true);

        if (!$productId || empty($data)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'Dados inválidos.']);
        }

        foreach ($data as $item) {
            $this->packItems->insert([
                'product_id'   => $productId,
                'product_sku'  => $item['sku'] ?? null,
                'product_type' => $item['type'] ?? 'simple',
                'qty'          => $item['qty'] ?? 1,
                'cost_price'   => $item['cost'] ?? 0,
                'base_price'   => $item['price'] ?? 0,
            ]);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Itens do pack atualizados com sucesso.']);
    }

    /**
     * Atualiza apenas a quantidade de um item
     */
    public function updateQty($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }

        $data = $this->request->getJSON(true);
        $qty  = $data['qty'] ?? null;

        if (!$id || !is_numeric($qty)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'Dados inválidos.']);
        }

        $this->packItems->update($id, ['qty' => $qty]);

        return $this->response->setJSON(['success' => true, 'message' => 'Quantidade atualizada.']);
    }

    /**
     * Remove um item individual do pack
     */
    public function deleteItem($id = null)
    {
        if (!$this->request->isAJAX() || !$id) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'Requisição inválida.']);
        }

        $deleted = $this->packItems->delete($id);

        return $this->response->setJSON([
            'success' => (bool) $deleted,
            'message' => $deleted ? 'Item removido com sucesso.' : 'Falha ao remover item.'
        ]);
    }


    /**
     * Lista os items de um pack
     */
    public function getPackItems($productId = null)
    {
        if (!$productId) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['success' => false, 'message' => 'ID do produto em falta.']);
        }

        $items = $this->packItems
            ->where('product_id', $productId)
            ->orderBy('id', 'ASC')
            ->findAll();

        return $this->response->setJSON(['success' => true, 'items' => $items]);
    }
}
