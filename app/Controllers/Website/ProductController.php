<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsCategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsVariantsAttributesModel;
use App\Models\Admin\Catalog\ProductsPackItemModel;
use App\Models\Admin\Catalog\ProductsVirtualModel;
use App\Models\Admin\Catalog\ProductsImagesModel;
use App\Models\Admin\Catalog\SuppliersModel;
use App\Models\Admin\Catalog\ProductsAttributesModel;
use App\Models\Admin\Catalog\ProductsAttributesValuesModel;

class ProductController extends BaseController
{
    protected $ProductsModel;
    protected $ProductsVariantsModel;
    protected $ProductsVariantsAttributesModel;
    protected $ProductsPackItemModel;
    protected $ProductsVirtualModel;
    protected $ProductsImagesModel;
    protected $ProductsCategoriesModel;
    protected $ProductsAttributesModel;
    protected $ProductsAttributesValuesModel;
    protected $SuppliersModel;

    public function __construct()
    {
        $this->ProductsModel = new ProductsModel();
        $this->ProductsVariantsModel = new ProductsVariantsModel();
        $this->ProductsVariantsAttributesModel = new ProductsVariantsAttributesModel();
        $this->ProductsPackItemModel = new ProductsPackItemModel();
        $this->ProductsVirtualModel = new ProductsVirtualModel();
        $this->ProductsImagesModel = new ProductsImagesModel();
        $this->ProductsCategoriesModel = new ProductsCategoriesModel();
        $this->ProductsAttributesModel = new ProductsAttributesModel();
        $this->ProductsAttributesValuesModel = new ProductsAttributesValuesModel();
        $this->SuppliersModel = new SuppliersModel();
    }
    public function index(string $slug)
    {
        $product = $this->ProductsModel
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $images = $this->ProductsImagesModel
            ->where('owner_id', $product['id'])
            ->orderBy('position', 'ASC')
            ->findAll();
        $variants = $this->ProductsVariantsModel
            ->where('product_id', $product['id'])
            ->where('status', 1)
            ->findAll();
        $attributes = [];
        foreach ($variants as $variant) {
            $variantAttrs = $this->ProductsVariantsAttributesModel
                ->where('variant_id', $variant['id'])
                ->findAll();
            foreach ($variantAttrs as $va) {
                $value = $this->ProductsAttributesValuesModel
                    ->find($va['attribute_value_id']);
                if (!$value) continue;
                $attr = $this->ProductsAttributesModel
                    ->find($value['attribute_id']);
                if (!$attr) continue;
                $attributes[$variant['id']]
                [$attr['code']][] = $value['value'];
            }
        }
        $attributesMeta = $this->ProductsAttributesModel
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        $relatedProducts = $this->ProductsModel
            ->where('status', 'active')
            ->where('category_id', $product['category_id'])
            ->where('id !=', $product['id'])
            ->limit(10)
            ->findAll();
        foreach ($relatedProducts as &$rp) {
            $rp['images'] = $this->ProductsImagesModel
                ->where('owner_id', $rp['id'])
                ->orderBy('position', 'ASC')
                ->findAll();
        }
        unset($rp);
        $packItems = [];
        $virtual   = null;
        if ($product['type'] === 'pack') {
            $packItems = $this->ProductsPackItemModel
                ->where('product_id', $product['id'])
                ->where('deleted_at', null)
                ->findAll();
        }
        if ($product['type'] === 'virtual') {
            $virtual = $this->ProductsVirtualModel
                ->where('product_id', $product['id'])
                ->where('deleted_at', null)
                ->first();
        }
        $now = date('Y-m-d H:i:s');

        $hasValidSpecial =
            !empty($product['special_price']) &&
            $product['special_price'] < $product['base_price_tax'] &&
            !empty($product['special_price_start']) &&
            !empty($product['special_price_end']) &&
            $product['special_price_start'] <= $now &&
            $product['special_price_end'] >= $now;

        if (!$hasValidSpecial) {
            $product['special_price'] = 0;
        }

        return view('website/product/index', [
            'product'          => $product,
            'images'           => $images,
            'variants'         => $variants,
            'attributes'       => $attributes,
            'attributesMeta'   => $attributesMeta,
            'relatedProducts'  => $relatedProducts,
            'packItems'        => $packItems,
            'virtual'          => $virtual,
        ]);
    }




}
