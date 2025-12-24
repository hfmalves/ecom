<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\ForceHTTPS;

use App\Filters\Admin\AuthFilter as AdminAuthFilter;
use App\Filters\Admin\NoAuthFilter as AdminNoAuthFilter;
use App\Filters\Website\AuthFilter as UserAuthFilter;
use App\Filters\Website\NoAuthFilter as UserNoAuthFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        // Core
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // ADMIN
        'adminAuth'   => AdminAuthFilter::class,
        'adminNoAuth' => AdminNoAuthFilter::class,

        // USER
        'userAuth'    => UserAuthFilter::class,
        'userNoAuth'  => UserNoAuthFilter::class,
    ];

    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            'honeypot',
        ],
        'after' => [
            'secureheaders',
        ],
    ];

    public array $methods = [];

    public array $filters = [
        // ADMIN
        'adminAuth' => [
            'before' => ['admin/*'],
        ],
        'adminNoAuth' => [
            'before' => ['admin/auth/*'],
        ],

        // USER
        'userAuth' => [
            'before' => ['user/account/*'],
        ],
        'userNoAuth' => [
            'before' => ['user/auth/*'],
        ],
    ];

}
