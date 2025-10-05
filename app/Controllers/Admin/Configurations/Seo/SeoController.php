<?php

namespace App\Controllers\Admin\Configurations\Seo;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Seo\SeoSettingModel;

class SeoController extends BaseController
{
    protected $seo;

    public function __construct()
    {
        $this->seo = new SeoSettingModel();
    }

    public function index()
    {
        $data['settings'] = $this->seo->first(); // Pega o registro único
        return view('admin/configurations/seo/index', $data);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (!$id || !$this->seo->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Configuração SEO não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (!$this->seo->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->seo->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Configurações SEO atualizadas com sucesso!',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
