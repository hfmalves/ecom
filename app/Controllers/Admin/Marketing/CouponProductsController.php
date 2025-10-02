<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Marketing\CouponsProductModel;

class CouponProductsController extends BaseController
{
    protected $couponsProductModel;
    public function __construct()
    {
        $this->couponsProductModel = new CouponsProductModel();

    }
    public function index()
    {
        //
    }
}
