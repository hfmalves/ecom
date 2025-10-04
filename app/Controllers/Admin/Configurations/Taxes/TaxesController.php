<?php

namespace App\Controllers\Admin\Configurations\Taxes;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Taxes\TaxModel;

class TaxesController extends BaseController
{
    protected $taxes;
    public function __construct()
    {
        $this->taxes = new TaxModel();
    }
    public function index()
    {
        $data['taxes'] = $this->taxes->findAll();
        return view('admin/configurations/taxes/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['is_active'] = $data['is_active'] ?? 1;
        $exists = $this->taxes
            ->where('name', $data['name'])
            ->where('country', $data['country'])
            ->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe um imposto com este nome e país.',
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->taxes->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->taxes->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->taxes->getInsertID();
        csrf_hash();
        $token = csrf_token();
        $hash  = csrf_hash();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Imposto criado com sucesso!',
            'id'       => $id,
            'csrf'     => [
                'token' => $token,
                'hash'  => $hash,
            ],
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->taxes->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Imposto não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->taxes->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->taxes->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Imposto atualizado com sucesso!',
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function delete()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->taxes->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Imposto não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->taxes->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o imposto.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Imposto eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
