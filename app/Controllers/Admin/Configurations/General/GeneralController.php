<?php

namespace App\Controllers\Admin\Configurations\General;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\General\GeneralModel;

class GeneralController extends BaseController
{
    protected $general;

    public function __construct()
    {
        $this->general = new GeneralModel();
    }

    public function index()
    {
        $data['settings'] = $this->general->first(); // Pega o registro único
        return view('admin/configurations/general/index', $data);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (!$id || !$this->general->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Configuração geral não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (!$this->general->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->general->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Configurações gerais atualizadas com sucesso!',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
