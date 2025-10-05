<?php

namespace App\Controllers\Admin\Configurations\Security;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Security\SecurityModel;

class SecurityController extends BaseController
{
    protected $security;

    public function __construct()
    {
        $this->security = new SecurityModel();
    }

    public function index()
    {
        $data['settings'] = $this->security->first();
        return view('admin/configurations/security/index', $data);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;
        // corrige os booleanos do AlpineJS
        $boolFields = [
            'enable_2fa',
            'csrf_protection',
            'require_uppercase',
            'require_numbers',
            'require_specials',
            'ip_block_enabled'
        ];

        foreach ($boolFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field] === '1' || $data[$field] === true ? 1 : 0;
            }
        }

        if (!$id || !$this->security->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Configuração SEO não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (!$this->security->update($id, $data)) {
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
