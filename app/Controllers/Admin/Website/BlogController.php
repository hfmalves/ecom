<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BlogController extends BaseController
{
    public function index()
    {
        return view('admin/website/blog/index');
    }
}
