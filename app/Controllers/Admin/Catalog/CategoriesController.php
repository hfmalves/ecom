<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;

class CategoriesController extends BaseController
{
    protected $categories;
    protected $products;

    public function __construct()
    {
        $this->categories = new CategoriesModel();
        $this->products = new ProductsModel();
    }
    public function index()
    {
        $categories = $this->categories->orderBy('position', 'ASC')->findAll();
        foreach ($categories as &$category) {
            $category['products_count'] = $this->products
                ->where('category_id', $category['id'])
                ->countAllResults();
        }
        $data = [
            'categories' => $categories,
        ];
        return view('admin/catalog/categories/index', $data);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['slug']) && ! empty($data['name'])) {
            helper('text'); // garante que o helper está carregado
            $data['slug'] = url_title(convert_accented_characters($data['name']), '-', true);
        }
        if (! isset($data['is_active'])) {
            $data['is_active'] = 0;
        }
        if (! $this->categories->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->categories->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = $this->categories->getInsertID();
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Categoria criada com sucesso!',
            'id'       => $id,
            'redirect' => base_url('admin/catalog/categories/edit/'.$id),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Categoria não encontrado');
        }
        $category = $this->categories->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Categoria com ID $id não encontrado");
        }
        $data = [
            'category' => $category
        ];
        return view('admin/catalog/categories/edit', $data);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $data['parent_id'] = null;
        $id   = $data['id'] ?? null;
        if (! $id || ! $this->categories->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Categoria não encontrada.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // ajusta regra do slug para update
        $this->categories->setValidationRule('slug', "required|min_length[2]|max_length[150]|is_unique[categories.slug,id,{$id}]");

        if (! $this->categories->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->categories->errors(),
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
