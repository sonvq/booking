<?php

namespace Modules\Bill\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Bill\Events\Handlers\RegisterBillSidebar;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanPublishConfiguration;

class BillServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterBillSidebar::class);
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Bill\Repositories\BillRepository',
            function () {
                $repository = new \Modules\Bill\Repositories\Eloquent\EloquentBillRepository(new \Modules\Bill\Entities\Bill());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Bill\Repositories\Cache\CacheBillDecorator($repository);
            }
        );
// add bindings

    }

    public function boot()
    {
        $this->publishConfig('bill', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerInvalidDeductAmount();
    }

    private function registerInvalidDeductAmount()
    {
        Validator::extend('invalid_deduct_amount', '\Modules\Bill\Validators\InvalidDeductAmountValidator@validate');
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
