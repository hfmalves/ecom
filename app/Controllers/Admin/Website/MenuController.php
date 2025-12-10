<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use App\Models\Website\MenuModel;

class MenuController extends BaseController
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    public function index()
    {
        $parentId = (int) ($this->request->getGet('parent_id') ?? 0);
        $menus = $this->menu
            ->where('parent_id', $parentId === 0 ? null : $parentId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        // árvore completa para seleção
        $allMenus = $this->menu->orderBy('sort_order', 'ASC')->findAll();
        $fullTree = $this->buildTree($allMenus);
        // breadcrumb igual às categorias
        $breadcrumb = [];
        $id = $parentId;
        while ($id > 0) {
            $item = $this->menu->find($id);
            if (!$item) break;
            $breadcrumb[] = $item;
            $id = (int) ($item['parent_id'] ?? 0);
        }
        $breadcrumb = array_reverse($breadcrumb);
        return view('admin/website/menu/index', [
            'tree'      => $menus,
            'fullTree'  => $fullTree,
            'parentId'  => $parentId,
            'breadcrumb'=> $breadcrumb,
        ]);
    }
    public function store()
    {
        $data = $this->request->getJSON(true);
        // parent null = root
        $data['parent_id'] = ($data['parent_id'] == 0) ? null : (int)$data['parent_id'];
        // bloco JSON mega menu
        if (!empty($data['block_items'])) {
            $data['block_data'] = json_encode($data['block_items'], JSON_UNESCAPED_SLASHES);
        }
        if (!$this->menu->insert($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->menu->errors(),
                'csrf' => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ]
            ]);
        }
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Menu criado com sucesso!',
            'id'       => $this->menu->getInsertID(),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ]
        ]);
    }
    public function edit($id)
    {
        $item = $this->menu->find($id);
        if (!$item)
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu não encontrado');
        $allMenus = $this->menu->where('id !=', $id)->findAll();
        $tree = $this->buildTree($allMenus);
        return view('admin/website/menu/edit', [
            'menu'      => $item,
            'fullTree'  => $tree
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        $id = $data['id'];
        $data['parent_id'] = ($data['parent_id'] == 0) ? null : (int)$data['parent_id'];
        if (!empty($data['block_items'])) {
            $data['block_data'] = json_encode($data['block_items'], JSON_UNESCAPED_SLASHES);
        }
        if (!$this->menu->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->menu->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ]
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Menu atualizado!',
        ]);
    }
    public function reorder()
    {
        $data = $this->request->getJSON(true);
        $ids = $data['ids'] ?? [];
        $parent = $data['parent_id'] ?? null;
        if ($parent == 0) $parent = null;
        $position = 1;
        foreach ($ids as $id) {
            $this->menu
                ->where('id', $id)
                ->set([
                    'sort_order' => $position++,
                    'parent_id'  => $parent
                ])
                ->update();
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Menus reordenados com sucesso.',
        ]);
    }
    public function enable()
    {
        $id = $this->request->getJSON(true)['id'];
        $this->menu->update($id, ['is_active' => 1]);
        return $this->response->setJSON([
            'status' => 'success',
            'message'=> 'Menu ativado.'
        ]);
    }
    public function disable()
    {
        $id = $this->request->getJSON(true)['id'];
        $this->menu->update($id, ['is_active' => 0]);
        return $this->response->setJSON([
            'status' => 'success',
            'message'=> 'Menu desativado.'
        ]);
    }
    private function buildTree(array $elements, $parent = null): array
    {
        $branch = [];
        foreach ($elements as $el) {
            if ($el['parent_id'] == $parent) {
                $children = $this->buildTree($elements, $el['id']);
                $el['children'] = $children;
                $branch[] = $el;
            }
        }
        return $branch;
    }
}
