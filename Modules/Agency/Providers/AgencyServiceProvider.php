<?php

namespace Modules\Agency\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Agency\Events\Handlers\RegisterAgencySidebar;

class AgencyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterAgencySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('agency', 'permissions');

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
            'Modules\Agency\Repositories\AgencyRepository',
            function () {
                $repository = new \Modules\Agency\Repositories\Eloquent\EloquentAgencyRepository(new \Modules\Agency\Entities\Agency());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Agency\Repositories\Cache\CacheAgencyDecorator($repository);
            }
        );
// add bindings

    }
}
