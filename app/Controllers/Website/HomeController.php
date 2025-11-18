<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;

// Website
use App\Models\Website\MenuModel;
use App\Models\Website\ModuleSliderModel;
use App\Models\Website\ModuleIconsModel;
use App\Models\Website\ModuleCategoryModel;
use App\Models\Website\ModuleBannerProductsPositionsModel;

// Catálogo
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;

class HomeController extends BaseController
{
    protected $menuModel;
    protected $sliderModel;
    protected $moduleIconsModel;

    protected $blockModel;   // website_module_categories
    protected $bannerModel;  // website_module_banner_products_positions

    protected $categoriesModel;
    protected $productsModel;

    public function __construct()
    {
        // Website
        $this->menuModel        = new MenuModel();
        $this->sliderModel      = new ModuleSliderModel();
        $this->moduleIconsModel = new ModuleIconsModel();

        // Categorias da homepage
        $this->blockModel       = new ModuleCategoryModel();

        // Banner LEFT/RIGHT
        $this->bannerModel      = new ModuleBannerProductsPositionsModel();

        // Catálogo
        $this->categoriesModel  = new CategoriesModel();
        $this->productsModel    = new ProductsModel();
    }
    public function index()
    {
        /* ============================
         * MENU
         * ============================ */
        $items = $this->menuModel
            ->where('is_active', 1)
            ->orderBy('parent_id ASC, sort_order ASC')
            ->findAll();
        $tree = [];
        foreach ($items as $item) {
            $tree[$item['parent_id']][] = $item;
        }
        /* ============================
         * SLIDES
         * ============================ */
        $slides = $this->sliderModel
            ->orderBy('sort_order ASC')
            ->findAll();
        $realPath   = FCPATH . 'assets/website/uploads/slides/';
        $publicPath = 'assets/website/uploads/slides/';
        foreach ($slides as &$s) {
            $imageName = trim($s['image'] ?? '');
            $s['image'] = ($imageName && is_file($realPath . $imageName))
                ? base_url($publicPath . $imageName)
                : 'https://placehold.co/1200x600?text=Sem+Imagem';

            $s['cta_url']  = $s['cta_url']  ?: '#';
            $s['cta_text'] = $s['cta_text'] ?: 'Ver mais';
            $s['title']    = $s['title']    ?: 'Sem título';
        }
        /* ============================
         * ICONS
         * ============================ */
        $icons = $this->moduleIconsModel
            ->where('is_active', 1)
            ->orderBy('sort_order ASC')
            ->findAll();
        /* ============================
         * BLOCO ÚNICO (website_module_categories)
         * ============================ */
        $block = $this->blockModel->first(); // só tens um bloco
        // category_ids guardados como JSON
        $ids = json_decode($block['category_ids'], true) ?: [];
        // buscar as categorias reais desse bloco
        $categories = $this->categoriesModel
            ->whereIn('id', $ids)
            ->findAll();
        // completar cada categoria
        foreach ($categories as &$c) {
            // total de produtos
            $c['total_products'] = $this->productsModel
                ->where('category_id', $c['id'])
                ->countAllResults();
            // imagem real
            if (!empty($c['image'])) {
                $c['image'] = base_url('uploads/categories/' . $c['image']);
            } else {
                $c['image'] = 'https://placehold.co/300x300?text=Sem+Imagem';
            }
        }
        /* ============================
 * BANNER PRODUCTS LEFT/RIGHT
 * ============================ */
        $bannerBlocks = $this->bannerModel
            ->orderBy('sort_order', 'ASC')
            ->findAll();

// Inicializar
        $leftBlock  = null;
        $rightBlock = null;

        foreach ($bannerBlocks as &$b) {

            // produtos
            $productIds = json_decode($b['product_ids'], true) ?? [];
            $b['products'] = $productIds
                ? $this->productsModel->whereIn('id', $productIds)->findAll()
                : [];

            // imagem
            $b['banner_image'] = !empty($b['banner_image'])
                ? base_url('uploads/banners/' . $b['banner_image'])
                : 'https://placehold.co/800x800?text=Sem+Imagem';

            // pins
            $b['pins'] = json_decode($b['pins'], true) ?: [];

            // separa LEFT e RIGHT
            if ($b['position'] === 'left') {
                $leftBlock = $b;
            }
            if ($b['position'] === 'right') {
                $rightBlock = $b;
            }
        }
        return view('website/home/index', [
            'menu_tree'  => $tree,
            'slides'     => $slides,
            'icons'      => $icons,
            'block'      => $block,
            'categories' => $categories,
            'leftBlock'     => $leftBlock,
            'rightBlock'    => $rightBlock,
        ]);
    }
}
