<?php

namespace Modules\Video\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        // $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->commands([
            // 
        ]);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('video.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'video'
        );
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/video');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/video';
        }, \Config::get('view.paths')), [$sourcePath]), 'video');
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/video');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'video');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'video');
        }
    }

    protected function registerFactories(): void
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    public function provides(): array
    {
        return [];
    }
}
