<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CartRulesController extends BaseController
{
    public function index()
    {
        $data = [

        ];
        return view('admin/marketing/cart-rules/index', $data);
    }
}
