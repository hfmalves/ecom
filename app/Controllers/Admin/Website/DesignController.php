<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DesignController extends BaseController
{
    public function index()
    {
        return view('admin/website/design/index');
    }
}
