<?php

namespace Modules\Room\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Room\Events\Handlers\RegisterRoomSidebar;

class RoomServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterRoomSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('room', 'permissions');

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
            'Modules\Room\Repositories\RoomRepository',
            function () {
                $repository = new \Modules\Room\Repositories\Eloquent\EloquentRoomRepository(new \Modules\Room\Entities\Room());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Room\Repositories\Cache\CacheRoomDecorator($repository);
            }
        );
// add bindings

    }
}
