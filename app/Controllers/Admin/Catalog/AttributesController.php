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
        $attribute = $this->attributes->find($id);
        if (!$attribute) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Fornecedor com ID $id não encontrado");
        }
        $data = [
            'attribute' => $attribute,
            'attributesValues' => $this->attributesValues->where('attribute_id', $attribute['id'])->orderBy('sort_order','ASC')->findAll(),
        ];
        return view('admin/catalog/attributes/edit', $data);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $data['parent_id'] = null;
        $id   = $data['id'] ?? null;
        if (! $id || ! $this->attributes->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'atributo não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->attributes->setValidationRule(
            'code',
            "required|max_length[100]|is_unique[products_attributes.code,id,{$id}]"
        );
        $this->attributes->setValidationRule(
            'name', "required|max_length[255]|is_unique[products_attributes.name,id,{$id}]"
        );
        if (! $this->attributes->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->attributes->errors(),
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

    /*
     * VALUES
     */
    public function updateValueOrder($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Fornecedor não encontrado');
        }
        $attribute = $this->attributes->find($id);
        if (!$attribute) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Fornecedor com ID $id não encontrado");
        }
        $data = [
            'attribute' => $attribute,
            'attributesValues' => $this->attributesValues->where('attribute_id', $attribute['id'])->orderBy('sort_order','ASC')->findAll(),
        ];
        return view('admin/catalog/attributes/edit', $data);
    }
}
