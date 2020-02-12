<?php

namespace Modules\Audit\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Audit\Events\Handlers\RegisterAuditSidebar;

class AuditServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterAuditSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('audit', 'permissions');

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
            'Modules\Audit\Repositories\AuditRepository',
            function () {
                $repository = new \Modules\Audit\Repositories\Eloquent\EloquentAuditRepository(new \Modules\Audit\Entities\Audit());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Audit\Repositories\Cache\CacheAuditDecorator($repository);
            }
        );
// add bindings

    }
}
