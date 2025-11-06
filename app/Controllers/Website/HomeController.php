<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index()
    {
        return view('website/home/index', [
        ]);
    }
}
