<?php

namespace App\Controllers\Admin\Configurations\Taxes;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Taxes\TaxModel;
use App\Models\Admin\Configurations\Countries\CountriesModel;

class TaxesController extends BaseController
{
    protected $taxes;
    protected $countries;

    public function __construct()
    {
        $this->taxes = new TaxModel();
        $this->countries = new CountriesModel();
    }

    public function index()
    {
        $data['taxes'] = $this->taxes->findAll();
        $data['countries'] = $this->countries->findAll();

        // Mapeia países por ID com todos os campos relevantes
        $countryMap = [];
        foreach ($data['countries'] as $country) {
            $countryMap[$country['id']] = [
                'name'       => $country['name'],
                'code'       => $country['code'] ?? '',
                'iso3'       => $country['iso3'] ?? '',
                'currency'   => $country['currency'] ?? '',
                'phone_code' => $country['phone_code'] ?? '',
            ];
        }

        // Junta os dados do país em cada taxa
        foreach ($data['taxes'] as &$tax) {
            $country = $countryMap[$tax['country_id']] ?? null;

            $tax['country_name']       = $country['name']       ?? '—';
            $tax['country_code']       = $country['code']       ?? '';
            $tax['country_iso3']       = $country['iso3']       ?? '';
            $tax['country_currency']   = $country['currency']   ?? '';
            $tax['country_phone_code'] = $country['phone_code'] ?? '';
        }

        return view('admin/configurations/taxes/index', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['is_active'] = $data['is_active'] ?? 1;
        $exists = $this->taxes
            ->where('name', $data['name'])
            ->where('country_id', $data['country_id'])
            ->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Já existe um imposto com este nome e país.',
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->taxes->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->taxes->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->taxes->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Imposto criado com sucesso!',
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
        if (! $id || ! $this->taxes->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Imposto não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->taxes->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->taxes->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Imposto atualizado com sucesso!',
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
        if (! $id || ! $this->taxes->find($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Imposto não encontrado.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->taxes->delete($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao eliminar o imposto.',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Imposto eliminado com sucesso!',
            'modalClose' => true,
            'csrf' => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}

