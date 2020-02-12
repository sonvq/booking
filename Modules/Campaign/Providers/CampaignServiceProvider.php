<?php

namespace Modules\Campaign\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Campaign\Events\Handlers\RegisterCampaignSidebar;

class CampaignServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCampaignSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('campaign', 'permissions');

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
            'Modules\Campaign\Repositories\CampaignRepository',
            function () {
                $repository = new \Modules\Campaign\Repositories\Eloquent\EloquentCampaignRepository(new \Modules\Campaign\Entities\Campaign());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Campaign\Repositories\Cache\CacheCampaignDecorator($repository);
            }
        );
// add bindings

    }
}
