<?php

namespace Modules\Booking\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Booking\Events\Handlers\RegisterBookingSidebar;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanPublishConfiguration;

class BookingServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterBookingSidebar::class);
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Booking\Repositories\BookingRepository',
            function () {
                $repository = new \Modules\Booking\Repositories\Eloquent\EloquentBookingRepository(new \Modules\Booking\Entities\Booking());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Booking\Repositories\Cache\CacheBookingDecorator($repository);
            }
        );
// add bindings

    }

    public function boot()
    {
        $this->publishConfig('booking', 'permissions');

        $this->registerBookingDateInRangeValidator();

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerBookingDateInRangeValidator()
    {
        Validator::extend('booking_date_in_range', '\Modules\Booking\Validators\BookingDateInRangeValidator@validate');
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
