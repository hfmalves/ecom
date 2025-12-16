<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;

use App\Models\Website\MenuModel;
use App\Models\Admin\Catalog\CategoriesModel;
use App\Models\Admin\Catalog\ProductsModel;

class HomeController extends BaseController
{
    protected $menuModel;
    protected $productsModel;

    public function __construct()
    {
        $this->menuModel         = new MenuModel();
        $this->categoriesModel   = new CategoriesModel();
        $this->productsModel     = new ProductsModel();
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
