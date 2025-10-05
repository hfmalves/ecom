<?php

namespace App\Controllers\Admin\Configurations\Emails;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Emails\EmailTemplateModel;

class EmailsController extends BaseController
{
    protected $emails;

    public function __construct()
    {
        $this->emails = new EmailTemplateModel();
    }

    public function index()
    {
        $data['emails'] = $this->emails->findAll();
        return view('admin/configurations/emails/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 1;

        if (! $this->emails->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->emails->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Template de email criado com sucesso!',
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

        if (! $id || ! $this->emails->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Template não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->emails->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->emails->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Template atualizado com sucesso!',
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

        if (! $id || ! $this->emails->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Template não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->emails->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar template.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Template eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
