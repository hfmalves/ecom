<?php

namespace App\Controllers\Admin\Configurations\Currencies;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Currencies\CurrencyModel;

class CurrenciesController extends BaseController
{
    protected $currencies;

    public function __construct()
    {
        $this->currencies = new CurrencyModel();
    }

    public function index()
    {
        $data['currencies'] = $this->currencies->findAll();

        return view('admin/configurations/currencies/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = $data['status'] ?? 1;
        $data['is_default'] = $data['is_default'] ?? 0;

        $exists = $this->currencies->where('code', $data['code'])->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe uma moeda com este código.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->currencies->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->currencies->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Moeda criada com sucesso!',
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

        if (! $id || ! $this->currencies->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Moeda não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->currencies->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->currencies->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Moeda atualizada com sucesso!',
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

        if (! $id || ! $this->currencies->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Moeda não encontrada.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        if (! $this->currencies->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar a moeda.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Moeda eliminada com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ]);
    }
}
