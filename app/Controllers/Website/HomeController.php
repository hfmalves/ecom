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
        return view('website/home/index', [
            'blocks' => [
                'hero',
            ],
        ]);
    }

}
