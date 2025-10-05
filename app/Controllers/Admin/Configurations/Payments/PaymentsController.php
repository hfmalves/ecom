<?php

namespace App\Controllers\Admin\Configurations\Payments;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Payments\PaymentMethodModel;

class PaymentsController extends BaseController
{
    protected $payments;

    public function __construct()
    {
        $this->payments = new PaymentMethodModel();
    }

    public function index()
    {
        // Busca todos os métodos de pagamento
        $data['payments'] = $this->payments->findAll();

        // Decodifica o config_json (pra exibir ou usar no painel)
        foreach ($data['payments'] as &$payment) {
            $payment['config'] = json_decode($payment['config_json'], true) ?? [];
        }

        return view('admin/configurations/payments/index', $data);
    }


    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['is_active'] = $data['is_active'] ?? 1;
        $data['is_default'] = $data['is_default'] ?? 0;

        // Evita duplicação pelo code
        $exists = $this->payments->where('code', $data['code'])->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe um método com este código.',
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->payments->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->payments->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $id = $this->payments->getInsertID();

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Método de pagamento criado com sucesso!',
            'id'       => $id,
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;

        if (! $id || ! $this->payments->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método de pagamento não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->payments->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->payments->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Método atualizado com sucesso!',
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

        if (! $id || ! $this->payments->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        if (! $this->payments->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o método de pagamento.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Método de pagamento eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}
