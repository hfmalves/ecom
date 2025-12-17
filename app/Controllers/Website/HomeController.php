<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;

use App\Models\Website\HomeModel;
use App\Models\Website\HomeBlockModel;
use App\Models\Website\BlockHeroModel;
use App\Models\Website\BlockHeroSlideModel;
use App\Models\Website\BlockGridBannerModel;
use App\Models\Website\BlockGridBannerItemModel;

use App\Models\Website\BlockProductsGridModel;
use App\Models\Website\BlockProductsGridItemModel;

use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Catalog\ProductsImagesModel;

class HomeController extends BaseController
{
    protected HomeModel $homeModel;
    protected HomeBlockModel $homeBlockModel;

    public function __construct()
    {
        $this->homeModel      = new HomeModel();
        $this->homeBlockModel = new HomeBlockModel();
    }

    public function index()
    {
        $home = $this->homeModel
            ->where('home_code', 'default')
            ->first();
        if (!$home) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Home não encontrada');
        }
        $blocks = $this->homeBlockModel
            ->where('home_id', $home['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();
        /**
         * RESOLVER BLOCOS (UM A UM)
         */
        foreach ($blocks as &$block) {

            switch ($block['block_type']) {

                case 'hero':
                    $block = $this->resolveHero($block);
                    break;

                case 'grid_banner':
                    $block = $this->resolveGridBanner($block);
                    break;

                case 'products_grid':
                    $block = $this->resolveProductsGrid($block);
                    break;
            }
        }
        unset($block);
        return view('website/home/index', [
            'home'   => $home,
            'blocks' => $blocks,
        ]);
    }
    private function resolveHero(array $block): array
    {
        $heroModel  = new BlockHeroModel();
        $slideModel = new BlockHeroSlideModel();
        $block['config'] = $heroModel
            ->where('block_id', $block['id'])
            ->first();
        $block['data'] = [
            'slides' => $slideModel
                ->where('block_id', $block['id'])
                ->orderBy('position', 'ASC')
                ->findAll()
        ];
        return $block;
    }
    private function resolveGridBanner(array $block): array
    {
        $gridModel  = new BlockGridBannerModel();
        $itemModel  = new BlockGridBannerItemModel();

        $block['config'] = $gridModel
            ->where('block_id', $block['id'])
            ->first();

        $items = $itemModel
            ->where('block_id', $block['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        $block['data'] = [
            'items' => $items,
        ];

        return $block;
    }
    /* ---------------- PRODUCTS GRID ---------------- */
    private function resolveProductsGrid(array $block): array
    {
        $gridModel = new BlockProductsGridModel();
        $itemModel = new BlockProductsGridItemModel();
        $config = $gridModel
            ->where('block_id', $block['id'])
            ->first();
        $products = [];
        if (($config['grid_type'] ?? '') === 'manual') {
            $items = $itemModel
                ->where('block_id', $block['id'])
                ->orderBy('position', 'ASC')
                ->findAll();
            foreach ($items as $item) {
                $products[] = $this->loadProduct($item['product_id'], $item['product_variant_id'] ?? null);
            }

        }
        else {
            $productModel = new ProductsModel();
            $rows = $productModel
                ->where('status', 'active')
                ->limit((int) ($config['items_limit'] ?? 8))
                ->findAll();
            foreach ($rows as $row) {
                $products[] = $this->loadProduct($row['id']);
            }
        }
        $products = array_values(array_filter($products));
        $block['blockConfig'] = $config;
        $block['products']    = $products;

        return $block;
    }

    /* ---------------- HELPERS ---------------- */
    private function loadProduct(int $productId, ?int $variantId = null): ?array
    {
        $productModel = new ProductsModel();
        $variantModel = new ProductsVariantsModel();
        $imageModel   = new ProductsImagesModel();
        $product = $productModel->find($productId);
        if (!$product) {
            return null;
        }
        if ($variantId) {
            $product['variation'] = $variantModel->find($variantId);
        }
        $product['images'] = $imageModel
            ->where('owner_id', $productId)
            ->orderBy('position', 'ASC')
            ->findAll();

        return $product;
    }

}
