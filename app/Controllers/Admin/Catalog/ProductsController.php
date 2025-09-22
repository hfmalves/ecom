<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Products;

class ProductsController extends BaseController
{
    protected $products;

    public function __construct()
    {
        $this->products = new Products(); // model
    }

    public function index()
    {
        $rawProducts = $this->products->findAll();

        // Prepara dados já prontos para a view
        $products = array_map(function ($p) {
            return [
                'id'       => $p['id'],
                'sku'      => $p['sku'],
                'name'     => $p['name'],
                'price'    => number_format($p['base_price'], 2, ',', '.') . ' €',
                'promo'    => !empty($p['special_price'])
                    ? '<span class="badge bg-success">'.number_format($p['special_price'], 2, ',', '.').' €</span>'
                    : '<span class="text-muted">—</span>',
                'stock'    => $p['manage_stock']
                    ? $p['stock_qty']
                    : '<span class="badge bg-info">Ilimitado</span>',
                'status'   => match($p['status']) {
                    'active'   => '<span class="badge bg-success">Ativo</span>',
                    'inactive' => '<span class="badge bg-secondary">Inativo</span>',
                    'draft'    => '<span class="badge bg-warning text-dark">Rascunho</span>',
                    default    => '<span class="badge bg-dark">Arquivado</span>',
                },
                'type'     => ucfirst($p['type']),
                'updated'  => !empty($p['updated_at'])
                    ? date('d/m/Y H:i', strtotime($p['updated_at']))
                    : '—',
                'actions'  => '
                    <a href="'.base_url('admin/catalog/products/edit/'.$p['id']).'" class="btn btn-sm btn-primary w-100">
                        <i class="mdi mdi-pencil"></i>
                    </a>'
            ];
        }, $rawProducts);

        $data = [
            'products' => $products
        ];

        return view('admin/catalog/products/index', $data);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produto não encontrado');
        }
        $product = $this->products->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produto com ID $id não encontrado");
        }
        $data = [
            'product' => $product
        ];
        return view('admin/catalog/products/edit', $data);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);
        foreach (['is_new', 'is_featured', 'manage_stock'] as $field) {
            if (isset($data[$field]) && is_bool($data[$field])) {
                $data[$field] = $data[$field] ? 1 : 0;
            }
        }
        if (! $this->products->validate($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->products->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $id = $data['id'] ?? null;
        if (! $id || ! $this->products->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Produto não encontrado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $this->products->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto atualizado com sucesso!',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
