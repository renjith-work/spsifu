<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'isAdmin' => \App\Http\Middleware\AdminMiddleware::class,
        'dashboard' => \App\Http\Middleware\DashboardMiddleware::class,
        'post' => \App\Http\Middleware\PostMiddleware::class,
        'postCategory' => \App\Http\Middleware\PostCategoryMiddleware::class,
        'postTag' => \App\Http\Middleware\PostTagMiddleware::class,
        'postStatus' => \App\Http\Middleware\PostStatusMiddleware::class,
        'product' => \App\Http\Middleware\ProductMiddleware::class,
        'productAttribute' => \App\Http\Middleware\ProductAttributeMiddleware::class,
        'productAttributeValue' => \App\Http\Middleware\ProductAttributeValueMiddleware::class,
        'productCategory' => \App\Http\Middleware\ProductCategoryMiddleware::class,
        'customProductCategory' => \App\Http\Middleware\CustomProductCategoryMiddleware::class,
        'productAttributeSet' => \App\Http\Middleware\ProductAttributeSetMiddleware::class,
        'productAttributeImageSettings' => \App\Http\Middleware\ProductAttributeImageSettingsMiddleware::class,
        'productDesignShirt' => \App\Http\Middleware\ProductDesignShirtMiddleware::class,
        'brand' => \App\Http\Middleware\BrandMiddleware::class,
        'fabric' => \App\Http\Middleware\FabricMiddleware::class,
        'fabricBrand' => \App\Http\Middleware\FabricBrandMiddleware::class,
        'fabricClass' => \App\Http\Middleware\FabricClassMiddleware::class,
        'taxClass' => \App\Http\Middleware\TaxClassMiddleware::class,
        'taxRate' => \App\Http\Middleware\TaxRateMiddleware::class,
        'inventoryUnit' => \App\Http\Middleware\InventoryUnitMiddleware::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
