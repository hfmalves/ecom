<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Marketing\CouponsCustomerGroupModel;
class CouponCustomerGroupsController extends BaseController
{
    protected $couponsCustomerGroupModel;
    public function __construct()
    {
        $this->couponsCustomerGroupModel = new CouponsCustomerGroupModel();

    }
    public function index()
    {
        //
    }
}
