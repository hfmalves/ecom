<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\SuppliersModel;

class SuppliersController extends BaseController
{
    protected $suppliers;
    protected $products;

    public function __construct()
    {
        $this->suppliers = new SuppliersModel();
        $this->products = new ProductsModel();
    }
    public function index()
    {
        $suppliers = $this->suppliers;
        $rawSuppliers = $suppliers->findAll();

        // === KPIs ===
        $totalSuppliers    = count($rawSuppliers);
        $ativosCount       = 0;
        $inativosCount     = 0;
        $altoRiscoCount    = 0;
        $comApiCount       = 0;
        $distinctCountries = [];
        $distinctCurrencies = [];
        $ibanValidCount    = 0;

        foreach ($rawSuppliers as $s) {
            if ($s['status'] === 'active') {
                $ativosCount++;
            } else {
                $inativosCount++;
            }
            if (!empty($s['api_url']) || !empty($s['api_key'])) {
                $comApiCount++;
            }
            if (!empty($s['risk_level']) && $s['risk_level'] === 'high') {
                $altoRiscoCount++;
            }
            if (!empty($s['iban'])) {
                $ibanValidCount++;
            }
            if (!empty($s['country'])) {
                $distinctCountries[$s['country']] = true;
            }
            if (!empty($s['currency'])) {
                $distinctCurrencies[$s['currency']] = true;
            }
        }
        $ativosPct = $totalSuppliers > 0 ? round(($ativosCount / $totalSuppliers) * 100, 1) : 0;
        $ibanPct   = $totalSuppliers > 0 ? round(($ibanValidCount / $totalSuppliers) * 100, 1) : 0;
        $data = [
            'suppliers' => $rawSuppliers,
            'kpi' => [
                'total'         => $totalSuppliers,
                'ativos'        => $ativosCount,
                'inativos'      => $inativosCount,
                'ativosPct'     => $ativosPct,
                'altoRisco'     => $altoRiscoCount,
                'apiLigados'    => $comApiCount,
                'paises'        => count($distinctCountries),
                'moedas'        => count($distinctCurrencies),
                'ibanPct'       => $ibanPct,
            ],
        ];
        return view('admin/catalog/suppliers/index', $data);
    }



    public function store()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['status'])) {
            $data['status'] = 'active';
        }
        if (! $this->suppliers->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->suppliers->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->suppliers->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Fornecedor criado com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/catalog/suppliers/edit/'.$id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Fornecedor não encontrado');
        }
        $supplier = $this->suppliers->find($id);
        if (!$supplier) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Fornecedor com ID $id não encontrado");
        }
        $data = [
            'supplier' => $supplier
        ];
        return view('admin/catalog/suppliers/edit', $data);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $data['parent_id'] = null;
        $id   = $data['id'] ?? null;
        if (! $id || ! $this->suppliers->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Categoria não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }


        // Corrigir a validação do email para ignorar o registo atual
        $this->suppliers->setValidationRule(
            'email',
            "required|valid_email|max_length[255]|is_unique[suppliers.email,id,{$id}]"
        );

        if (! $this->suppliers->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->suppliers->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categoria atualizada com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
}
