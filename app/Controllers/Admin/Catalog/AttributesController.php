<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Products;
use App\Models\Admin\ProductsAttributes;
use App\Models\Admin\ProductsAttributesValues;
use CodeIgniter\HTTP\ResponseInterface;

class AttributesController extends BaseController
{
    protected $products;
    protected $attributes;
    protected $attributesValues;

    public function __construct()
    {
        $this->products = new Products(); // model
        $this->attributes = new ProductsAttributes();
        $this->attributesValues = new ProductsAttributesValues();
    }

    public function index()
    {
        $data = [
            'atributes' => $this->attributes->findAll(),
        ];
        return view('admin/catalog/attributes/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (! $this->attributes->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->attributes->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $id = $this->attributes->getInsertID();

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Atributo criado com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/catalog/attributes/edit/'.$id),
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
