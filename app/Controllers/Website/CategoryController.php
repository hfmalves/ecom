<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsCategoriesModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsVirtualModel;
use App\Models\Admin\Catalog\ProductsPackItemModel;
use App\Models\Admin\Catalog\ProductsAttributesModel;
use App\Models\Admin\Catalog\ProductsAttributesValuesModel;

class CategoryController extends BaseController
{
    protected CategoriesModel $categoriesModel;
    protected ProductsModel $productsModel;
    protected ProductsCategoriesModel $productsCategoriesModel;
    protected ProductsVariantsModel $variantsModel;
    protected ProductsVirtualModel $virtualModel;
    protected ProductsPackItemModel $packItemModel;
    protected ProductsAttributesModel $attributesModel;
    protected ProductsAttributesValuesModel $attributesValuesModel;

    public function __construct()
    {
        $this->categoriesModel        = new CategoriesModel();
        $this->productsModel          = new ProductsModel();
        $this->productsCategoriesModel= new ProductsCategoriesModel();
        $this->variantsModel          = new ProductsVariantsModel();
        $this->virtualModel           = new ProductsVirtualModel();
        $this->packItemModel          = new ProductsPackItemModel();
        $this->attributesModel      = new ProductsAttributesModel();
        $this->attributeValuesModel = new ProductsAttributesValuesModel();
    }

    public function index(string $slug = null)
    {
        if (!$slug) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Categoria atual
        $category = $this->categoriesModel
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$category) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Todas as categorias (sidebar)
        $allCategories = $this->categoriesModel
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        // Subcategorias
        $subcategories = $this->categoriesModel
            ->where('parent_id', $category['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        // Produtos da categoria
        $products   = [];
        $productIds = $this->productsCategoriesModel
            ->where('category_id', $category['id'])
            ->findColumn('product_id');

        if (!empty($productIds)) {
            $products = $this->productsModel
                ->whereIn('id', $productIds)
                ->findAll();
        }

        // ============================
        // ATRIBUTOS (via VARIANTS)
        // ============================

        $attributes = [];

        if (!empty($productIds)) {

            // 1️⃣ Variants dos produtos
            $variantIds = $this->variantsModel
                ->whereIn('product_id', $productIds)
                ->where('status', 1)
                ->findColumn('id');

            if (!empty($variantIds)) {

                // 2️⃣ Attribute Value IDs usados nessas variants
                $attributeValueIds = $this->db
                    ->table('products_variant_attributes')
                    ->select('attribute_value_id')
                    ->whereIn('variant_id', $variantIds)
                    ->groupBy('attribute_value_id')
                    ->get()
                    ->getResultArray();

                $attributeValueIds = array_column($attributeValueIds, 'attribute_value_id');

                if (!empty($attributeValueIds)) {

                    // 3️⃣ Atributos filtráveis
                    $attributes = $this->attributesModel
                        ->where('is_active', 1)
                        ->where('is_filterable', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

                    foreach ($attributes as $k => &$attribute) {

                        $attribute['values'] = $this->attributeValuesModel
                            ->where('attribute_id', $attribute['id'])
                            ->whereIn('id', $attributeValueIds)
                            ->orderBy('sort_order', 'ASC')
                            ->findAll();

                        if (empty($attribute['values'])) {
                            unset($attributes[$k]);
                        }
                    }
                }
            }
        }

        return view('website/category/index', [
            'category'      => $category,
            'allCategories' => $allCategories,
            'subcategories' => $subcategories,
            'products'      => $products,
            'attributes'    => $attributes,
        ]);
    }


}
