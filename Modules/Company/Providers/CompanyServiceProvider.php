<?php

namespace Modules\Company\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Company\Events\Handlers\RegisterCompanySidebar;

class CompanyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCompanySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('company', 'permissions');

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
            'Modules\Company\Repositories\CompanyRepository',
            function () {
                $repository = new \Modules\Company\Repositories\Eloquent\EloquentCompanyRepository(new \Modules\Company\Entities\Company());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Company\Repositories\Cache\CacheCompanyDecorator($repository);
            }
        );
// add bindings

    }
}
