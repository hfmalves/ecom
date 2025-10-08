<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsVariantsModel;

class ProductVariantsController extends BaseController
{
    protected $variants;

    public function __construct()
    {
        $this->variants = new ProductsVariantsModel();
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }

        $input = $this->request->getJSON(true);
        $id = (int) ($input['id'] ?? 0);

        if ($id <= 0) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'ID da variante em falta.']);
        }

        $data = [
            'id'             => $id,
            'sku'            => $input['sku'] ?? null,
            'cost_price'     => $input['cost_price'] ?? null,
            'base_price'     => $input['base_price'] ?? null,
            'base_price_tax' => $input['base_price_tax'] ?? null,
            'stock_qty'      => $input['stock_qty'] ?? null,
            'manage_stock'   => $input['manage_stock'] ?? 0,
            'is_default'     => $input['is_default'] ?? 0,
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        try {
            $updated = $this->variants->update($id, $data);

            if (!$updated) {
                return $this->response->setJSON([
                    'success'   => false,
                    'message'   => 'Falha ao atualizar variante.',
                    'errors'    => $this->variants->errors(),
                    'lastQuery' => (string) $this->variants->db->getLastQuery(),
                    'csrf'    => csrf_hash(),
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Variante atualizada com sucesso!',
                'data'    => $data,
                'csrf'    => csrf_hash(),
            ]);

        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Erro interno: ' . $e->getMessage(),
                ]);
        }
    }

}
