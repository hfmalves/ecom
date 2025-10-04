<?php

namespace App\Controllers\Admin\Configurations\Languages;

use App\Controllers\BaseController;

class LanguagesController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/languages/index');
    }
}
