<?php

namespace App\Controllers\Admin\Configurations\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Catalog\CatalogSettingModel;

class CatalogController extends BaseController
{
    protected $catalog;

    public function __construct()
    {
        $this->catalog = new CatalogSettingModel();
    }

    public function index()
    {
        $data['catalog'] = $this->catalog->findAll();
        return view('admin/configurations/catalog/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 1;

        if (! $this->catalog->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->catalog->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Configuração adicionada!',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (!$id || !$this->catalog->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Configuração não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->catalog->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->catalog->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Configuração atualizada!',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }

    public function delete()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (!$id || !$this->catalog->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Configuração não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->catalog->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar configuração.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Configuração eliminada!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
