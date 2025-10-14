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

        // Remove o token CSRF e outros campos desnecessários
        unset($input['csrf_test_name'], $input['csrf_token_name']);

        // Garante que updated_at é atualizado
        $input['updated_at'] = date('Y-m-d H:i:s');

        try {
            $updated = $this->variants->update($id, $input);

            if (!$updated) {
                return $this->response->setJSON([
                    'success'   => false,
                    'message'   => 'Falha ao atualizar variante.',
                    'errors'    => $this->variants->errors(),
                    'lastQuery' => (string) $this->variants->db->getLastQuery(),
                    'csrf'      => csrf_hash(),
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Variante atualizada com sucesso!',
                'data'    => $input,
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

    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['success' => false, 'message' => 'Acesso inválido.']);
        }
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'ID da variante em falta.']);
        }
        try {
            $variant = $this->variants->find($id);
            if (!$variant) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['success' => false, 'message' => 'Variante não encontrada.']);
            }
            $this->variants->delete($id);
            if ($this->variants->db->affectedRows() === 0) {
                return $this->response->setStatusCode(500)
                    ->setJSON(['success' => false, 'message' => 'Falha ao eliminar a variante.']);
            }
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Variante eliminada com sucesso.',
                'id'      => $id,
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
