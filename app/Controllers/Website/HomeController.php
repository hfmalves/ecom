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

use App\Models\Website\BlockBlogGridModel;
use App\Models\Website\BlockBlogGridItemModel;

use App\Models\Website\BlogCategoryModel;
use App\Models\Website\BlogCommentModel;
use App\Models\Website\BlogPostCategoryModel;
use App\Models\Website\BlogPostModel;

use App\Models\Website\BlockHomeDealsDayModel;
use App\Models\Website\BlockHomeDealsDayItemModel;

use App\Models\Website\BlockServicePromotionModel;
use App\Models\Website\BlockServicePromotionItemModel;

use App\Models\Website\FaqModel;
use App\Models\Website\FaqItemModel;

use App\Models\Website\BlockTopCategoryFilterModel;
use App\Models\Website\BlockTopCategoryFilterTabItemModel;
use App\Models\Website\BlockTopCategoryFilterTabModel;


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
            ->where('is_active', '1')
            ->first();
        if (!$home) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Home não encontrada');
        }
        $blocks = $this->homeBlockModel
            ->where('home_id', $home['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();
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
                case 'home_deals_day':
                    $block = $this->resolveHomeDealsDay($block);
                    break;
                case 'blog_grid':
                    $block = $this->resolveBlogGrid($block);
                    break;
                case 'service_promotion':
                    $block = $this->resolveServicePromotion($block);
                    break;
                case 'faq':
                    $block = $this->resolveFaq($block);
                    break;
                case 'top_category_filter':
                    $block = $this->resolveTopCategoryFilter($block);
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
    private function resolveHomeDealsDay(array $block): array
    {
        $configModel=new BlockHomeDealsDayModel();
        $itemModel=new BlockHomeDealsDayItemModel();
        $productModel=new ProductsModel();
        $variantModel=new ProductsVariantsModel();
        $imageModel=new ProductsImagesModel();
        $config=$configModel->where('block_id',$block['id'])->first();
        $items=$itemModel->where('block_id',$block['id'])->where('is_active',1)->orderBy('position','ASC')->findAll();
        $products=[];
        foreach($items as $item){
            $product=null;
            $variant=null;
            if(!empty($item['product_id'])){
                $product=$productModel->find($item['product_id']);
            }
            if(!$product&&!empty($item['product_variant_id'])){
                $variant=$variantModel->find($item['product_variant_id']);
                if($variant){
                    $product=$productModel->find($variant['product_id']);
                }
            }
            if(!$product){
                continue;
            }
            if($variant){
                $product['variation']=$variant;
            }
            if(!empty($variant['image'])){
                $product['images']=[['path'=>$variant['image']]];
            }else{
                $product['images']=$imageModel->where('owner_id',$product['id'])->orderBy('position','ASC')->findAll();
            }
            $product['in_wishlist']=false;
            $products[]=$product;
        }
        $block['blockConfig']=$config;
        $block['products']=$products;
        return $block;
    }
    private function resolveBlogGrid(array $block): array
    {
        $gridModel = new BlockBlogGridModel();
        $itemModel = new BlockBlogGridItemModel();
        $postModel = new BlogPostModel();

        $config = $gridModel
            ->where('block_id', $block['id'])
            ->first();

        $items = $itemModel
            ->where('block_id', $block['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->limit((int)($config['items_limit'] ?? 3))
            ->findAll();

        foreach ($items as &$item) {
            if (!empty($item['post_id'])) {
                $post = $postModel->find($item['post_id']);
                if ($post && !empty($post['featured_image'])) {
                    $item['image'] = $post['featured_image'];
                }
            }
        }
        unset($item);

        $block['blockConfig'] = $config;
        $block['items']      = $items;

        return $block;
    }
    private function resolveServicePromotion(array $block): array
    {
        $configModel = new BlockServicePromotionModel();
        $itemModel   = new BlockServicePromotionItemModel();

        $config = $configModel
            ->where('block_id', $block['id'])
            ->first();

        $items = $itemModel
            ->where('block_id', $block['id'])
            ->orderBy('position', 'ASC')
            ->findAll();

        $block['blockConfig'] = $config;
        $block['items']       = $items;

        return $block;
    }

    private function resolveFaq(array $block): array
    {
        $faqModel     = new FaqModel();
        $faqItemModel = new FaqItemModel();

        $faq = $faqModel
            ->where('context_type', 'home')
            ->where('context_id', $block['home_id'])
            ->where('is_active', 1)
            ->first();

        if (!$faq) {
            $block['faq']   = null;
            $block['items'] = [];
            return $block;
        }

        $items = $faqItemModel
            ->where('faq_id', $faq['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        $block['faq']   = $faq;
        $block['items'] = $items;

        return $block;
    }
    private function resolveTopCategoryFilter(array $block): array
    {
        $configModel  = new BlockTopCategoryFilterModel();
        $tabModel     = new BlockTopCategoryFilterTabModel();
        $itemModel    = new BlockTopCategoryFilterTabItemModel();
        $productModel = new ProductsModel();
        $variantModel = new ProductsVariantsModel();
        $imageModel   = new ProductsImagesModel();

        // 1. CONFIG
        $block['blockConfig'] = $configModel
            ->where('block_id', $block['id'])
            ->first();

        // 2. TABS
        $tabs = $tabModel
            ->where('block_id', $block['id'])
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->findAll();

        foreach ($tabs as &$tab) {

            // 3. ITEMS DA TAB (items_limit VEM DA TAB)
            $items = $itemModel
                ->where('tab_id', $tab['id'])
                ->where('is_active', 1)
                ->orderBy('position', 'ASC')
                ->limit((int) $tab['items_limit'])
                ->findAll();

            foreach ($items as &$item) {

                $product = null;
                $variant = null;

                if (!empty($item['product_variant_id'])) {

                    $variant = $variantModel->find($item['product_variant_id']);

                    if ($variant) {
                        $product = $productModel->find($variant['product_id']);
                    }

                } elseif (!empty($item['product_id'])) {

                    $product = $productModel->find($item['product_id']);
                }

                if (!$product) {
                    continue;
                }

                // IMAGEM
                if ($variant && !empty($variant['image'])) {

                    $product['images'] = [
                        ['path' => $variant['image']]
                    ];

                } else {

                    $product['images'] = $imageModel
                        ->where('owner_id', $product['id'])
                        ->orderBy('position', 'ASC')
                        ->findAll();
                }

                $item['product']  = $product;
                $item['variant']  = $variant;
            }


            $tab['items'] = array_values(array_filter($items));
        }

        $block['tabs'] = $tabs;
        return $block;
    }






}
