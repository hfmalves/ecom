<?php

namespace App\Controllers\Admin\Configurations\Shipping;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Shipping\ShippingMethodModel;

class ShippingController extends BaseController
{
    protected $shipping;

    public function __construct()
    {
        $this->shipping = new ShippingMethodModel();
    }

    public function index()
    {
        $data['shipping'] = $this->shipping->findAll();

        foreach ($data['shipping'] as &$ship) {
            $ship['config'] = json_decode($ship['config_json'], true) ?? [];
        }

        return view('admin/configurations/shipping/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['is_active'] = $data['is_active'] ?? 1;
        $data['free_shipping_min'] = $data['free_shipping_min'] ?? 0;

        $exists = $this->shipping->where('code', $data['code'])->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe um método com este código.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->shipping->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->shipping->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Método de envio criado com sucesso!',
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->shipping->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método de envio não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->shipping->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->shipping->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Método de envio atualizado com sucesso!',
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

        if (! $id || ! $this->shipping->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->shipping->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o método de envio.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Método eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}
