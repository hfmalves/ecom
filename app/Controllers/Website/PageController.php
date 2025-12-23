<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\Website\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PageController extends BaseController
{
    protected PageModel $pageModel;
    public function __construct()
    {
        $this->pageModel = new PageModel();
    }
    public function index(string $slug = null)
    {
        if ($slug === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $page = $this->pageModel
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();
        if (!$page) {
            throw PageNotFoundException::forPageNotFound();
        }
        // -------------------------
        // NEWSLETTER (cache decide)
        // -------------------------
        $newsletter = $page['newsletter'] ?? null;
        $seen = cache()->get(
            'newsletter_seen_' . md5($this->request->getIPAddress())
        );
        if ($seen) {
            $newsletter = null;
        }
        return view('website/page/index', [
            'page'       => $page,
            'newsletter' => $newsletter,
        ]);
    }
}
