<?php

/*
 * This file is part of the xuejd3/larabook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Xuejd3\LaraBook\Commands\ClearCacheCommand;
use Xuejd3\LaraBook\Commands\InstallCommand;
use Xuejd3\LaraBook\Commands\RefreshCommand;
use Xuejd3\LaraBook\Contracts\Renderer;
use Xuejd3\LaraBook\Renders\Markdown;

/**
 * Class LaraBookServiceProvider.
 */
class LaraBookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerAssets();
        $this->registerCommands();
    }

    public function register()
    {
        $this->bindContracts();
        $this->mergeConfigFrom(
            __DIR__ . '/../config/larabook.php', 'larabook'
        );
    }

    protected function registerRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::namespace(__NAMESPACE__ . '\Http\Controllers')
            ->middleware(config('larabook.middleware', []))
            ->group(function () {
                $route = config('larabook.route', 'docs');

                Route::get($route, 'DocsController@index')->name('larabook.docs.index');
                Route::get(\sprintf('%s/{version?}/{page?}', $route), 'DocsController@show')
                    ->name('larabook.docs.show')
                    ->where('page', '[\w\-\/]+');
            });
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                RefreshCommand::class,
                ClearCacheCommand::class,
            ]);
        }
    }

    protected function registerAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/larabook'),
        ], 'larabook-assets');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'larabook');

        // all
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/larabook'),
        ], 'larabook-views');

        // ads
        $this->publishes([
            __DIR__ . '/../resources/views/ads' => resource_path('views/vendor/larabook/ads'),
        ], 'larabook-views-ads');

        // partials
        $this->publishes([
            __DIR__ . '/../resources/views/partials' => resource_path('views/vendor/larabook/partials'),
        ], 'larabook-views-partials');

        // plugins
        $this->publishes([
            __DIR__ . '/../resources/views/plugins' => resource_path('views/vendor/larabook/plugins'),
        ], 'larabook-views-plugins');

        // errors
        $this->publishes([
            __DIR__ . '/../resources/views/plugins' => resource_path('views/vendor/larabook/errors'),
        ], 'larabook-views-errors');

        // docs
        $this->publishes([
            __DIR__ . '/../resources/views/docs.blade.php' => resource_path('views/vendor/larabook/docs.blade.php'),
        ], 'larabook-views-docs');

        // layout
        $this->publishes([
            __DIR__ . '/../resources/views/layout.blade.php' => resource_path('views/vendor/larabook/layout.blade.php'),
        ], 'larabook-views-layout');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'larabook');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/larabook'),
        ], 'larabook-lang');
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/larabook.php' => \config_path('larabook.php'),
        ], 'larabook-config');
    }

    public function bindContracts()
    {
        $this->app->bind(Renderer::class, Markdown::class);
    }
}
