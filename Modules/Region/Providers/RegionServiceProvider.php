<?php

namespace Modules\Region\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Region\Events\Handlers\RegisterRegionSidebar;

class RegionServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterRegionSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('region', 'permissions');

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
            'Modules\Region\Repositories\RegionRepository',
            function () {
                $repository = new \Modules\Region\Repositories\Eloquent\EloquentRegionRepository(new \Modules\Region\Entities\Region());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Region\Repositories\Cache\CacheRegionDecorator($repository);
            }
        );
// add bindings

    }
}
