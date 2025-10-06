<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\BrandsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\SuppliersModel;
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsVariantsAttributes;
use App\Models\Admin\Catalog\ProductsAttributesModel;
use App\Models\Admin\Catalog\ProductsAttributesValuesModel;

class ProductsController extends BaseController
{
    protected $products;
    protected $suppliers;
    protected $brands;
    protected $categories;
    protected $productsVariants;
    protected $productsVariantsAttributes;
    protected $productsAttributesModel;
    protected $productsAttributesValues;


    public function __construct()
    {
        $this->products = new ProductsModel();
        $this->suppliers = new SuppliersModel();
        $this->brands = new BrandsModel();
        $this->categories = new CategoriesModel();

        $this->productsVariants = new ProductsVariantsModel();
        $this->productsVariantsAttributes = new ProductsVariantsAttributes();
        $this->productsAttributesModel = new ProductsAttributesModel();
        $this->productsAttributesValues = new ProductsAttributesValuesModel();
    }

    public function index()
    {
        $rawProducts = $this->products->findAll();
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

        // Carrega atributos se for produto configurável
        $attributes = [];
        if ($product['type'] === 'configurable') {
            $attributes = $this->productsAttributesModel
                ->select('id, code, name, type')
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            foreach ($attributes as &$attr) {
                $attr['values'] = $this->productsAttributesValues
                    ->where('attribute_id', $attr['id'])
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();

                // 🔧 Limpa valores problemáticos (aspas duplas)
                foreach ($attr['values'] as &$val) {
                    $val['value'] = str_replace('"', "'", $val['value']);
                }
            }
        }

        $data = [
            'suppliers'   => $this->suppliers->findAll(),
            'brands'      => $this->brands->findAll(),
            'categories'  => $this->categories->findAll(),
            'product'     => $product,
            'attributes'  => $attributes
        ];
        //dd($data);
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
    public function store()
    {
        $data = $this->request->getJSON(true);
        $data['status'] = 'draft';
        $data['visibility'] = 'none';
        $data['base_price'] = '0.0';
        if (! empty($data['sku']) && ! empty($data['name'])) {
            $slug = url_title($data['sku'] . '-' . $data['name'], '-', true);
            $data['slug'] = $slug;
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
        $id = $this->products->insert($data);
        if (! $id) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao criar produto.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produto criado com sucesso!',
            'id'      => $id,
            'redirect' => base_url('admin/catalog/products/edit/'.$id),
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }


}
