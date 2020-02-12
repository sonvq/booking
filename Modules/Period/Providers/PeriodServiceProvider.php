<?php

namespace Modules\Period\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Period\Events\Handlers\RegisterPeriodSidebar;

class PeriodServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPeriodSidebar::class);
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Period\Repositories\PeriodRepository',
            function () {
                $repository = new \Modules\Period\Repositories\Eloquent\EloquentPeriodRepository(new \Modules\Period\Entities\Period());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Period\Repositories\Cache\CachePeriodDecorator($repository);
            }
        );
// add bindings

    }

    public function boot()
    {

        $this->registerDateNotConflictValidator();
        $this->registerNotContainNullValidator();
        $this->registerDateInOrderValidator();
        $this->registerDateNotConflictOtherValidator();

        $this->publishConfig('period', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerDateInOrderValidator()
    {
        Validator::extend('date_in_order', '\Modules\Period\Validators\DateInOrderValidator@validate');
    }

    private function registerNotContainNullValidator()
    {
        Validator::extend('not_contain_null', '\Modules\Period\Validators\NotContainNullValidator@validate');
    }

    private function registerDateNotConflictValidator()
    {
        Validator::extend('date_not_conflict', '\Modules\Period\Validators\DateNotConflictValidator@validate');
    }

    private function registerDateNotConflictOtherValidator()
    {
        Validator::extend('date_not_conflict_other', '\Modules\Period\Validators\DateNotConflictOtherValidator@validate');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
