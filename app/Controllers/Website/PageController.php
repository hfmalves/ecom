<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Website\PageModel;

class PageController extends BaseController
{

    public function index(string $slug = null)
    {
        if ($slug === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $pageModel = new PageModel();

        $page = $pageModel
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$page) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('website/page/index', [
            'page' => $page,
        ]);
    }
}
