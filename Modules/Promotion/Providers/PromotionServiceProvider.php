<?php

namespace Modules\Promotion\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Promotion\Events\Handlers\RegisterPromotionSidebar;

class PromotionServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPromotionSidebar::class);
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Promotion\Repositories\PromotionRepository',
            function () {
                $repository = new \Modules\Promotion\Repositories\Eloquent\EloquentPromotionRepository(new \Modules\Promotion\Entities\Promotion());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Promotion\Repositories\Cache\CachePromotionDecorator($repository);
            }
        );
// add bindings

    }

    public function boot()
    {
        $this->registerPromotionDateNotConflictValidator();
        $this->registerPromotionDateNotConflictCampaignDateValidator();

        $this->publishConfig('promotion', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerPromotionDateNotConflictValidator()
    {
        Validator::extend('promotion_date_not_conflict', '\Modules\Promotion\Validators\PromotionDateNotConflictValidator@validate');
    }

    private function registerPromotionDateNotConflictCampaignDateValidator()
    {
        Validator::extend('promotion_date_not_conflict_campaign_date', '\Modules\Promotion\Validators\PromotionDateNotConflictCampaignDateValidator@validate');
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
