<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Website\SliderModel;

class SliderController extends BaseController
{
    protected $slider;

    public function __construct()
    {
        $this->slider = new SliderModel();
    }

    public function index()
    {
        $data['slides'] = $this->slider
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('website/home/slideshow', $data);
    }
}
