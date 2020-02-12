<?php

namespace Modules\Service\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Service\Events\Handlers\RegisterServiceSidebar;

class ServiceServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterServiceSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('service', 'permissions');

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
            'Modules\Service\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Service\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Service\Entities\Service());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Service\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
// add bindings

    }
}
