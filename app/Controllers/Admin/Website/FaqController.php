<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FaqController extends BaseController
{
    public function index()
    {
        return view('admin/website/faq/index');
    }
}
