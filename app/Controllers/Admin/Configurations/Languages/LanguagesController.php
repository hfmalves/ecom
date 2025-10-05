<?php

namespace App\Controllers\Admin\Configurations\Languages;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Languages\LanguageModel;

class LanguagesController extends BaseController
{
    protected $languages;

    public function __construct()
    {
        $this->languages = new LanguageModel();
    }

    public function index()
    {
        $data['languages'] = $this->languages->orderBy('name', 'ASC')->findAll();
        return view('admin/configurations/languages/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);

        if (! $this->languages->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->languages->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        $id = $this->languages->getInsertID();
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Idioma criado com sucesso!',
            'id' => $id,
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

        if (! $id || ! $this->languages->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Idioma não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->languages->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->languages->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Idioma atualizado com sucesso!',
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

        if (! $id || ! $this->languages->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Idioma não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->languages->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o idioma.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Idioma eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
