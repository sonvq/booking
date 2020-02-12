<?php

namespace Modules\Supplier\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Supplier\Events\Handlers\RegisterSupplierSidebar;

class SupplierServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterSupplierSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('supplier', 'permissions');

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
            'Modules\Supplier\Repositories\SupplierRepository',
            function () {
                $repository = new \Modules\Supplier\Repositories\Eloquent\EloquentSupplierRepository(new \Modules\Supplier\Entities\Supplier());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Supplier\Repositories\Cache\CacheSupplierDecorator($repository);
            }
        );
// add bindings

    }
}
