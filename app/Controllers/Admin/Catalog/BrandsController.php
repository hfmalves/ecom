<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\BrandsModel;
use App\Models\Admin\Catalog\ProductsModel;

class BrandsController extends BaseController
{
    protected $brands;
    protected $products;

    public function __construct()
    {
        $this->brands = new BrandsModel();
        $this->products = new ProductsModel();
    }
    public function index()
    {
        $brands = $this->brands->findAll();
        $data = [
            'brands' => $brands,
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Marca não encontrado');
        }
        $brands = $this->brands->find($id);
        if (!$brands) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Marca com ID $id não encontrado");
        }
        $data = [
            'brands' => $brands
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