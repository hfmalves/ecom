<?php

namespace App\Controllers\Admin\Configurations\Integrations;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Integrations\IntegrationModel;

class IntegrationsController extends BaseController
{
    protected $integrations;

    public function __construct()
    {
        $this->integrations = new IntegrationModel();
    }

    public function index()
    {
        $data['integrations'] = $this->integrations->findAll();

        foreach ($data['integrations'] as &$i) {
            $i['config'] = json_decode($i['config_json'], true) ?? [];
        }

        return view('admin/configurations/integrations/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 1;

        $exists = $this->integrations->where('name', $data['name'])->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe uma integração com este nome.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->integrations->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->integrations->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Integração criada com sucesso!',
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

        if (! $id || ! $this->integrations->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Integração não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->integrations->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->integrations->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Integração atualizada com sucesso!',
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

        if (! $id || ! $this->integrations->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Integração não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->integrations->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar a integração.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Integração eliminada com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
