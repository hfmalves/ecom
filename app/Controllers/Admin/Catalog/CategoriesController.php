<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Categories;
use CodeIgniter\HTTP\ResponseInterface;

class CategoriesController extends BaseController
{
    protected $categories;

    public function __construct()
    {
        $this->categories = new Categories(); // model
    }

    public function index()
    {
        $allCategories = $this->categories->orderBy('position', 'ASC')->findAll();
        $categories = $this->buildTree($allCategories);

        $data = [
            'categories' => $categories,
        ];

        return view('admin/catalog/categories/index', $data);
    }
    private function buildTree(array $elements, $parentId = null, $level = 0): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $element['level'] = $level; // guarda o nível para indentação
                $children = $this->buildTree($elements, $element['id'], $level + 1);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
