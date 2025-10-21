<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\BrandsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\SuppliersModel;
class BrandsController extends BaseController
{
    protected $brands;
    protected $products;
    protected $suppliers;

    public function __construct()
    {
        $this->brands = new BrandsModel();
        $this->products = new ProductsModel();
        $this->suppliers = new SuppliersModel();
    }
    public function index()
    {
        // === Buscar todas as marcas ===
        $brands = $this->brands->findAll();

        // === Agregar dados adicionais ===
        foreach ($brands as &$brand) {
            // total de produtos associados
            $brand['product_count'] = $this->products
                ->where('brand_id', $brand['id'])
                ->countAllResults();

            // fornecedor
            $supplier = $this->suppliers
                ->select('name')
                ->where('id', $brand['supplier_id'])
                ->get()
                ->getRowArray();
            $brand['supplier_name'] = $supplier['name'] ?? '—';
        }

        // === KPIs ===
        $totalBrands     = count($brands);
        $activeBrands    = array_sum(array_column($brands, 'is_active'));
        $featuredBrands  = array_sum(array_column($brands, 'featured'));
        $totalProducts   = $this->products->countAllResults();

        $data = [
            'brands' => $brands,
            'kpi' => [
                'total'     => $totalBrands,
                'active'    => $activeBrands,
                'featured'  => $featuredBrands,
                'products'  => $totalProducts,
            ],
        ];

        return view('admin/catalog/brands/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['is_active'])) {
            $data['is_active'] = '1';
        }
        if (empty($data['slug']) && ! empty($data['name'])) {
            helper('text'); // garante que o helper está carregado
            $data['slug'] = url_title(convert_accented_characters($data['name']), '-', true);
        }
        if (! $this->brands->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->brands->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->brands->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Marca criado com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/catalog/brands/edit/'.$id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Marca não encontrada');
        }
        $brand = $this->brands->find($id);
        if (!$brand) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Marca com ID {$id} não encontrada");
        }
        $suppliers = $this->suppliers
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->findAll();
        $data = [
            'brands'    => $brand,
            'suppliers' => $suppliers,
        ];
        return view('admin/catalog/brands/edit', $data);
    }

    public function update()
    {
        $data = $this->request->getJSON(true);
        $id   = $data['id'] ?? null;

        if (! $id || ! $this->brands->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Marca não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $this->brands->setValidationRule(
            'name',
            "required|min_length[2]|max_length[150]|is_unique[brands.name,id,{$id}]"
        );

        $this->brands->setValidationRule(
            'slug',
            "required|min_length[2]|max_length[150]|is_unique[brands.slug,id,{$id}]"
        );

        if (! $this->brands->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->brands->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Marca atualizada com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }


}