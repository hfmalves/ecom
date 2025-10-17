<?php

namespace App\Controllers\Admin\Catalog;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\BrandsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsImagesModel;
use App\Models\Admin\Catalog\SuppliersModel;
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsVariantsAttributes;
use App\Models\Admin\Catalog\ProductsAttributesModel;
use App\Models\Admin\Catalog\ProductsAttributesValuesModel;
use App\Models\Admin\Catalog\ProductsVirtualModel;

use App\Models\Admin\Configurations\Taxes\TaxModel;

class ProductsController extends BaseController
{
    protected $products;
    protected $productsImages;
    protected $suppliers;
    protected $brands;
    protected $categories;
    protected $productsVariants;
    protected $productsVariantsAttributes;
    protected $productsAttributesModel;
    protected $productsAttributesValues;
    protected $productsVirtualModel;

    protected $TaxModel;


    public function __construct()
    {
        $this->products = new ProductsModel();
        $this->productsImages = new ProductsImagesModel();
        $this->suppliers = new SuppliersModel();
        $this->brands = new BrandsModel();
        $this->categories = new CategoriesModel();

        $this->productsVariants = new ProductsVariantsModel();
        $this->productsVariantsAttributes = new ProductsVariantsAttributes();
        $this->productsAttributesModel = new ProductsAttributesModel();
        $this->productsAttributesValues = new ProductsAttributesValuesModel();
        $this->productsVirtualModel = new ProductsVirtualModel();
        $this->TaxModel = new TaxModel();
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

                foreach ($attr['values'] as &$val) {
                    $val['value'] = str_replace('"', "'", $val['value']);
                }
            }
            unset($attr, $val);
        }
        $variants = $this->productsVariants->where('product_id', $id)->findAll();
        $variantAttrs = $this->productsVariantsAttributes->findAll();
        $allValues = $this->productsAttributesValues
            ->select('id, value')
            ->findAll();
        $mapValues = array_column($allValues, 'value', 'id');
        foreach ($variants as &$variant) {
            $variant['attributes'] = [];
            $variant['attribute_names'] = [];

            foreach ($variantAttrs as $va) {
                if ((int)$va['variant_id'] == (int)$variant['id']) {
                    $valId = (int)$va['attribute_value_id'];
                    $variant['attributes'][] = $valId;
                    $variant['attribute_names'][] = $mapValues[$valId] ?? '—';
                }
            }
            $variantImages = $this->productsImages
                ->where('owner_type', 'variant')
                ->where('owner_id', $variant['id'])
                ->orderBy('position', 'ASC')
                ->findAll();

            $variant['images'] = array_map(fn($img) => [
                'id'       => (int) $img['id'],
                'url'      => '/' . ltrim($img['path'], '/'),
                'alt_text' => $img['alt_text'] ?? '',
            ], $variantImages);
        }

        unset($variant);
        $images = $this->productsImages
            ->where('owner_type', 'product')
            ->where('owner_id', $id)
            ->orderBy('position', 'ASC')
            ->findAll();

        $product['images'] = array_map(fn($img) => [
            'id'       => (int) $img['id'],
            'url'      => '/' . ltrim($img['path'], '/'),
            'alt_text' => $img['alt_text'] ?? '',
        ], $images);
        $productImagesJson = json_encode($product['images'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $productImagesEscaped = htmlspecialchars($productImagesJson, ENT_QUOTES, 'UTF-8');

        $baseProductsForPack = $this->products
            ->select('id, name, sku, type, cost_price, base_price')
            ->whereNotIn('type', ['pack'])
            ->findAll();
        $variantListForPack = $this->productsVariants
            ->select('id, product_id, sku, cost_price, base_price')
            ->findAll();
        $parentsMap = [];
        foreach ($baseProductsForPack as $p) {
            $parentsMap[$p['id']] = $p['name'];
        }
        $availableProducts = [];
        foreach ($baseProductsForPack as $p) {
            if ($p['type'] === 'simple') {
                $availableProducts[] = [
                    'sku'    => $p['sku'],
                    'name'   => $p['name'],
                    'price'  => (float) $p['base_price'],
                    'cost'   => (float) $p['cost_price'],
                    'type'   => 'simple',
                    'parent' => null,
                    'label'  => "{$p['name']} ({$p['sku']})",
                ];
            }
        }
        foreach ($variantListForPack as $v) {
            $parentName = $parentsMap[$v['product_id']] ?? '—';
            $availableProducts[] = [
                'sku'    => $v['sku'],
                'name'   => $v['sku'], // ou outro campo se existir
                'price'  => (float) $v['base_price'],
                'cost'   => (float) $v['cost_price'],
                'type'   => 'variant',
                'parent' => $parentName,
                'label'  => "{$parentName} — {$v['sku']}",
            ];
        }
        $availableProductsJson = json_encode($availableProducts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $availableProductsEscaped = htmlspecialchars($availableProductsJson, ENT_QUOTES, 'UTF-8');

        // Dados do produto virtual (se existir)
        $virtual = $this->productsVirtualModel
            ->where('product_id', $id)
            ->first();

        if ($virtual) {
            $product['virtual_type'] = $virtual['virtual_type'];
            $product['virtual_file'] = !empty($virtual['virtual_file']) ? '/' . ltrim($virtual['virtual_file'], '/') : null;
            $product['virtual_url']  = $virtual['virtual_url'] ?? null;
            $product['virtual_expiry_days'] = $virtual['virtual_expiry_days'] ?? 0;
        }
        $data = [
            'suppliers'                   => $this->suppliers->findAll(),
            'brands'                      => $this->brands->findAll(),
            'categories'                  => $this->categories->findAll(),
            'product'                     => $product,
            'product_tax'                 => $this->TaxModel->findAll(),
            'attributes'                  => json_encode($attributes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'productsVariants'            => json_encode($variants, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'productsVariantsAttributes'  => json_encode($variantAttrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'productImages'               => $productImagesEscaped, // 👈 usar este no HTML
            'availableProducts'           => $availableProductsEscaped, // 👈 igual às imagens
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
        foreach (['special_price_start', 'special_price_end'] as $dateField) {
            if (!empty($data[$dateField])) {
                $dt = \DateTime::createFromFormat('d-m-Y', $data[$dateField]);
                if ($dt) {
                    $data[$dateField] = $dt->format('Y-m-d 00:00:00');
                } else {
                    // Tenta fallback (ISO padrão do input type=date)
                    $dt = \DateTime::createFromFormat('Y-m-d', $data[$dateField]);
                    if ($dt) {
                        $data[$dateField] = $dt->format('Y-m-d 00:00:00');
                    }
                }
            } else {
                $data[$dateField] = null;
            }
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
