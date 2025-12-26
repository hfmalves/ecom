<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use App\Models\Website\HomeModel;
class ShowcasesController extends BaseController
{
    protected $HomeModel;

    public function __construct()
    {
        $this->HomeModel = new HomeModel();
    }
    public function index()
    {
        $showcases = $this->HomeModel->findAll();
        return view('admin/website/showcases/index', [
            'showcases' => $showcases,
        ]);
    }
    public function create()
    {
        $data = $this->request->getJSON(true);
        $isDefault = !empty($data['is_default']) ? 1 : 0;
        if ($isDefault === 1) {
            $this->HomeModel
                ->where('store_id', 1)
                ->set(['is_default' => 0])
                ->update();
        }
        $insert = [
            'store_id'     => 1,
            'home_code' => 'home-' . (
                    ($this->HomeModel
                        ->where('store_id', 1)
                        ->withDeleted()
                        ->countAllResults()) + 1
                ),
            'name'         => $data['name'] ?? null,
            'is_active'    => !empty($data['is_active']) ? 1 : 0,
            'is_default'   => $isDefault,
            'active_start' => $data['active_start'] ?: null,
            'active_end'   => $data['active_end'] ?: null,
        ];
        $this->HomeModel->insert($insert);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Home criada com sucesso'
        ]);
    }
    public function edit($id)
    {
        $showcase = $this->HomeModel->find($id);
        if (!$showcase) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/website/showcases/edit', [
            'showcase' => $showcase,
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);

        $id = $data['id'] ?? null;
        if (! $id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID em falta',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // regra: default único
        if (!empty($data['is_default'])) {
            $this->HomeModel
                ->where('store_id', 1)
                ->where('id !=', $id)
                ->set(['is_default' => 0])
                ->update();
        }

        $update = [
            'name'         => $data['name'] ?? null,
            'is_active'    => !empty($data['is_active']) ? 1 : 0,
            'is_default'   => !empty($data['is_default']) ? 1 : 0,
            'active_start' => $data['active_start'] ?: null,
            'active_end'   => $data['active_end'] ?: null,
        ];

        if (! $this->HomeModel->update($id, $update)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->HomeModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Home atualizada com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function deactivate()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID inválido'
            ]);
        }
        $this->HomeModel->update($data['id'], [
            'is_active' => 0,
        ]);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Home desativada com sucesso'
        ]);
    }
    public function delete()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID inválido'
            ]);
        }
        $this->HomeModel->delete($data['id']);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Home eliminada com sucesso'
        ]);
    }
}
