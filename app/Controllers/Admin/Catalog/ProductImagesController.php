<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductImagesModel;

class ProductImagesController extends BaseController
{
    protected $ProductImagesModel;

    public function __construct()
    {
        $this->ProductImagesModel = new ProductImagesModel();
    }

    /**
     * Upload de imagem (product ou variant)
     */
    public function upload()
    {
        $file = $this->request->getFile('file');
        $ownerType = $this->request->getPost('owner_type') ?? 'product';
        $ownerId   = $this->request->getPost('owner_id');
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => 'Ficheiro inválido ou já movido.']);
        }
        $uploadPath = FCPATH . 'uploads/products/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);
        $relativePath = 'uploads/products/' . $newName;
        $id = $this->ProductImagesModel->insert([
            'owner_type' => $ownerType,
            'owner_id'   => $ownerId,
            'path'       => $relativePath,
            'position'   => 0,
            'alt_text'   => $file->getClientName(),
        ]);
        return $this->response->setJSON([
            'id'        => $id,
            'path'      => $relativePath,
            'alt_text'  => $file->getClientName(),
        ]);
    }
    public function delete($id = null)
    {
        $image = $this->ProductImagesModel->find($id);
        if (! $image) {
            return $this->response->setStatusCode(404)
                ->setJSON(['error' => 'Imagem não encontrada.']);
        }
        $filePath = FCPATH . $image['path'];
        if (is_file($filePath)) {
            @unlink($filePath);
        }
        $this->ProductImagesModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
    public function reorder()
    {
        $order = $this->request->getJSON(true);

        if (! is_array($order)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => 'Formato inválido.']);
        }

        foreach ($order as $pos => $id) {
            $this->ProductImagesModel->update($id, ['position' => $pos + 1]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
