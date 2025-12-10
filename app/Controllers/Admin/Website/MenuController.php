<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MenuController extends BaseController
{
    public function index()
    {
        return view('admin/website/menu/index');
    }
}
