<?php

namespace App\Controllers\Admin\Configurations\Cache;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Cache\CacheSettingModel;

class CacheController extends BaseController
{
    protected $cache;

    public function __construct()
    {
        $this->cache = new CacheSettingModel();
    }

    public function index()
    {
        $data['cache'] = $this->cache->orderBy('driver', 'ASC')->findAll();
        return view('admin/configurations/cache/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        if (!empty($data['config_json'])) {
            // valida se é um JSON válido, se não for, tenta escapar corretamente
            json_decode($data['config_json']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data['config_json'] = json_encode(json_decode(stripslashes($data['config_json'])), JSON_UNESCAPED_UNICODE);
            }
        }
        if (!$this->cache->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->cache->errors(),
                'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Cache criado com sucesso!',
            'id' => $this->cache->getInsertID(),
            'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;
        if (!empty($data['config_json'])) {
            // valida se é um JSON válido, se não for, tenta escapar corretamente
            json_decode($data['config_json']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data['config_json'] = json_encode(json_decode(stripslashes($data['config_json'])), JSON_UNESCAPED_UNICODE);
            }
        }
        if (!$id || !$this->cache->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Cache não encontrado.',
                'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
            ]);
        }

        if (!$this->cache->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->cache->errors(),
                'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Cache atualizado com sucesso!',
            'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
        ]);
    }

    public function delete()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (!$id || !$this->cache->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Cache não encontrado.',
                'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
            ]);
        }

        if (!$this->cache->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o cache.',
                'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Cache eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => ['token' => csrf_token(), 'hash' => csrf_hash()]
        ]);
    }
}
