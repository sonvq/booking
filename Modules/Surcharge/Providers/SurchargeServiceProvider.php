<?php

namespace Modules\Surcharge\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Surcharge\Events\Handlers\RegisterSurchargeSidebar;

class SurchargeServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterSurchargeSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('surcharge', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Surcharge\Repositories\SurchargeRepository',
            function () {
                $repository = new \Modules\Surcharge\Repositories\Eloquent\EloquentSurchargeRepository(new \Modules\Surcharge\Entities\Surcharge());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Surcharge\Repositories\Cache\CacheSurchargeDecorator($repository);
            }
        );
// add bindings

    }
}
