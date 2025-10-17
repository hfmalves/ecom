<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsVirtualModel;

class ProductsVirtualController extends BaseController
{
    protected $productsVirtualModel;

    public function __construct()
    {
        $this->productsVirtualModel = new ProductsVirtualModel();
    }

    // Criar / Atualizar
    public function save($productId)
    {
        $data = $this->request->getJSON(true);

        if (!$productId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Product ID é obrigatório.']);
        }

        $existing = $this->productsVirtualModel->where('product_id', $productId)->first();

        if ($existing) {
            $this->productsVirtualModel->update($existing['id'], $data);
        } else {
            $data['product_id'] = $productId;
            $this->productsVirtualModel->insert($data);
        }

        return $this->response->setJSON(['success' => true]);
    }

    // Obter dados
    public function show($productId)
    {
        $record = $this->productsVirtualModel->where('product_id', $productId)->first();

        return $this->response->setJSON(['data' => $record ?? null]);
    }

    // Apagar
    public function delete($id)
    {
        $this->productsVirtualModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    // Upload de ficheiro
    // Upload de ficheiro
    public function upload($productId)
    {
        helper('filesystem');
        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Ficheiro inválido.']);
        }
        $uploadPath = ROOTPATH . 'public/uploads/virtuals/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);
        $path = 'uploads/virtuals/' . $newName;
        $existing = $this->productsVirtualModel->where('product_id', $productId)->first();
        $data = [
            'virtual_file' => $path,
            'virtual_type' => 'download',
        ];
        if ($existing) {
            $this->productsVirtualModel->update($existing['id'], $data);
        } else {
            $data['product_id'] = $productId;
            $data['virtual_expiry_days'] = 0;
            $this->productsVirtualModel->insert($data);
        }
        return $this->response->setJSON([
            'success' => true,
            'path' => base_url($path),
        ]);
    }

}
