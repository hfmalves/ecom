<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;

use App\Models\Website\MenuModel;
use App\Models\Website\ModuleSliderModel;
use App\Models\Website\ModuleIconsModel;
use App\Models\Website\ModuleCategoryModel;
use App\Models\Website\ModuleBannerProductsPositionsModel;
use App\Models\Website\ModuleProductLoopLinkModel;
use App\Models\Website\ModuleProductLoopCategoryModel;
use App\Models\Website\ModuleProductLoopCategoryProductsModel;
use App\Models\Website\ModuleTestimonialModel;

use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;

use App\Models\Website\ModuleHomeModel; // novo model

class HomeController extends BaseController
{
    protected $menuModel;
    protected $modulesModel;
    protected $sliderModel;
    protected $iconsModel;
    protected $categoryBlockModel;
    protected $bannerModel;
    protected $categoriesModel;
    protected $productsModel;

    public function __construct()
    {
        $this->menuModel         = new MenuModel();
        $this->modulesModel      = new ModuleHomeModel();
        $this->sliderModel       = new ModuleSliderModel();
        $this->iconsModel        = new ModuleIconsModel();
        $this->categoryBlockModel = new ModuleCategoryModel();
        $this->bannerModel       = new ModuleBannerProductsPositionsModel();
        $this->categoriesModel   = new CategoriesModel();
        $this->productsModel     = new ProductsModel();
        $this->moduleLoopModel       = new ModuleProductLoopLinkModel();
        $this->moduleLoopCatModel    = new ModuleProductLoopCategoryModel();
        $this->moduleLoopProdModel   = new ModuleProductLoopCategoryProductsModel();
        $this->moduleTestimonialModel  = new ModuleTestimonialModel();
    }
    public function index()
    {
        $items = $this->menuModel
            ->where('is_active', 1)
            ->orderBy('parent_id ASC, sort_order ASC')
            ->findAll();
        $tree = [];
        foreach ($items as $item) {
            $tree[$item['parent_id']][] = $item;
        }
        // módulos da home
        $modules = $this->modulesModel
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        foreach ($modules as &$module) {
            switch ($module['type']) {
                /* -----------------------------------------
                    SLIDER
                ------------------------------------------ */
                case 'slider_01':
                    $module['data'] = $this->sliderModel
                        ->where('is_active', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();
                    break;
                /* -----------------------------------------
                    ICONS
                ------------------------------------------ */
                case 'box_icons':
                    $module['data'] = $this->iconsModel
                        ->where('is_active', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();
                    break;
                /* -----------------------------------------
                    CATEGORY LOOP
                ------------------------------------------ */
                case 'category_loop_01':
                    $block = $this->categoryBlockModel->first();
                    $module['data'] = [];
                    if ($block) {
                        $ids = json_decode($block['category_ids'], true) ?? [];
                        if (!empty($ids)) {
                            $cats = $this->categoriesModel
                                ->whereIn('id', $ids)
                                ->findAll();
                            foreach ($cats as &$c) {
                                $c['total_products'] = $this->productsModel
                                    ->where('category_id', $c['id'])
                                    ->countAllResults();
                            }
                            $module['data'] = $cats;
                        }
                        $module['title'] = $block['title'];
                        $module['subtitle'] = $block['subtitle'];
                    }
                    break;
                /* -----------------------------------------
                    BANNERS LEFT
                ------------------------------------------ */
                case 'banner_product_left':
                    $block = $this->bannerModel
                        ->where('position', 'left')
                        ->first();
                    if ($block) {
                        $productIds = json_decode($block['product_ids'], true) ?? [];
                        if (!empty($productIds)) {
                            $products = $this->productsModel
                                ->whereIn('id', $productIds)
                                ->findAll();
                        } else {
                            $products = [];
                        }
                        $module['data'] = [
                            'products' => $products,
                            'pins'     => json_decode($block['pins'], true) ?? [],
                            'banner'   => $block['banner_image'] ?? null,
                        ];
                        $module['title']    = $block['title'] ?? '';
                        $module['subtitle'] = $block['subtitle'] ?? '';
                    } else {
                        $module['data'] = [
                            'products' => [],
                            'pins'     => [],
                            'banner'   => null
                        ];
                    }
                    break;
                /* -----------------------------------------
                    BANNERS RIGHT
                ------------------------------------------ */
                case 'banner_product_right':
                    $block = $this->bannerModel
                        ->where('position', 'right')
                        ->first();
                    if ($block) {
                        $productIds = json_decode($block['product_ids'], true) ?? [];
                        $products = !empty($productIds)
                            ? $this->productsModel->whereIn('id', $productIds)->findAll()
                            : [];
                        $module['data'] = [
                            'products' => $products,
                            'pins'     => json_decode($block['pins'], true) ?? [],
                            'banner'   => $block['banner_image'],
                        ];
                        $module['title'] = $block['title'];
                        $module['subtitle'] = $block['subtitle'];
                    } else {
                        $module['data'] = [];
                    }
                    break;
                /* -----------------------------------------
                    PRODUCT LOOP LINK
                ------------------------------------------ */
                case 'product_loop_link':
                    $block = $this->moduleLoopModel
                        ->where('is_active', 1)
                        ->first();
                    if (!$block) {
                        $module['data'] = [];
                        break;
                    }
                    $categories = $this->moduleLoopCatModel
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();
                    foreach ($categories as &$cat) {
                        $productLinks = $this->moduleLoopProdModel
                            ->where('module_category_id', $cat['id'])
                            ->orderBy('sort_order', 'ASC')
                            ->findAll();
                        $productIds = array_column($productLinks, 'product_id');
                        $cat['products'] = !empty($productIds)
                            ? $this->productsModel->whereIn('id', $productIds)->findAll()
                            : [];
                    }
                    $module['title']    = $block['title'];
                    $module['subtitle'] = $block['subtitle'];
                    $module['data']     = $categories;
                    break;
                /* -----------------------------------------
                            TESTIMONIAL
                ------------------------------------------ */
                case 'testimonial':

                    // Buscar todos os testimonhos ativos e ordenados
                    $testimonials = $this->moduleTestimonialModel
                        ->where('is_active', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

                    if (empty($testimonials)) {
                        $module['data'] = [];
                        break;
                    }

                    // Buscar produtos associados
                    foreach ($testimonials as &$item) {
                        $item['product'] = null;

                        if (!empty($item['product_id'])) {
                            $item['product'] = $this->productsModel
                                ->where('id', $item['product_id'])
                                ->first();
                        }
                    }

                    $module['title']    = 'Customer Reviews';
                    $module['subtitle'] = 'Up to 50% off Lorem ipsum dolor sit amet, consectetur adipiscing elit';
                    $module['data']     = $testimonials;

                    break;

            }
        }
        return view('website/home/index', [
            'menu_tree' => $tree,
            'modules'   => $modules
        ]);
    }

}
