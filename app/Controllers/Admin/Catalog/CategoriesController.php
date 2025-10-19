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
        $parentId = (int) ($this->request->getGet('parent_id') ?? 0);
        $parentCategory = $parentId > 0 ? $this->categories->find($parentId) : null;
        $parentParentId = $parentCategory['parent_id'] ?? 0;
        $categories = $this->categories
            ->groupStart()
            ->where('parent_id', $parentId === 0 ? null : $parentId)
            ->orWhere('parent_id', $parentId)
            ->groupEnd()
            ->orderBy('position', 'ASC')
            ->findAll();
        foreach ($categories as &$category) {
            $category['products_count'] = $this->products
                ->where('category_id', $category['id'])
                ->countAllResults();
        }
        $allCategories = $this->categories->orderBy('position', 'ASC')->findAll();
        $categoryTree = $this->buildTree($allCategories);
        $breadcrumb = [];
        $currentId = $parentId;
        while ($currentId > 0) {
            $cat = $this->categories->find($currentId);
            if (!$cat) break;
            $breadcrumb[] = $cat;
            $currentId = (int) ($cat['parent_id'] ?? 0);
        }
        $breadcrumb = array_reverse($breadcrumb);
        return view('admin/catalog/categories/index', [
            'tree'          => $categories,
            'fullTree'      => $categoryTree,
            'parentId'      => $parentId,
            'breadcrumb'    => $breadcrumb,
            'parentParentId'=> $parentParentId, // 👈 usado para o botão voltar
        ]);
    }


    public function store()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['parent_id']) || $data['parent_id'] == '0') {
            $data['parent_id'] = null; // categoria principal
        } else {
            $data['parent_id'] = (int)$data['parent_id']; // subcategoria
        }
        if (empty($data['slug']) && !empty($data['name'])) {
            helper('text');
            $data['slug'] = url_title(convert_accented_characters($data['name']), '-', true);
        }
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }
        if (!$this->categories->insert($data)) {
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
    public function reorder()
    {
        $data = $this->request->getJSON(true);
        $ids        = $data['ids']        ?? [];
        $parent_id  = $data['parent_id']  ?? null;
        if ($parent_id == 0) $parent_id = null;
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nenhuma categoria recebida.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $position = 1;
        foreach ($ids as $id) {
            $this->categories
                ->where('id', $id)
                ->set([
                    'position'   => $position++,
                    'parent_id'  => $parent_id,
                    'updated_at' => date('Y-m-d H:i:s')
                ])
                ->update();
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Categorias reordenadas com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }
    private function buildTree(array $elements, int $parentId = 0): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ((int)$element['parent_id'] === $parentId) {
                $children = $this->buildTree($elements, (int)$element['id']);
                $element['children'] = $children ?: [];
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
