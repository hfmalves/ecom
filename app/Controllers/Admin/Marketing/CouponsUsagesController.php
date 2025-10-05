<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Marketing\CouponsUsagesModel;

class CouponsUsagesController extends BaseController
{
    protected $couponsUsages;
    public function __construct()
    {
        $this->couponsUsages = new CouponsUsagesModel();
    }
    public function index()
    {
        $data = [

        ];
        return view('admin/marketing/catalog-rules/index', $data);
    }
}
