<?php

namespace KyleWLawrence\GForms\Providers;

use Illuminate\Support\ServiceProvider;
use KyleWLawrence\GForms\Services\GFormsService;
use KyleWLawrence\GForms\Services\NullService;

class GFormsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider and merge config.
     *
     * @return void
     */
    public function register()
    {
        $packageName = 'gravity-forms-laravel';
        $configPath = __DIR__.'/../../config/gravity-forms-laravel.php';

        $this->mergeConfigFrom(
            $configPath, $packageName
        );

        $this->publishes([
            $configPath => config_path(sprintf('%s.php', $packageName)),
        ]);
    }

    /**
     * Bind service to 'GForms' for use with Facade.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('GForms', function () {
            $driver = config('gravity-forms-laravel.driver', 'api');
            if (is_null($driver) || $driver === 'log') {
                return new NullService($driver === 'log');
            }

            return new GFormsService;
        });
    }
}
