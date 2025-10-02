<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Marketing\CouponsCategoryModel;

class CouponCategoriesController extends BaseController
{
    protected $couponsCategoryModel;

    public function __construct()
    {
        $this->couponsCategoryModel = new CouponsCategoryModel();

    }
    public function index()
    {
        //
    }
}
