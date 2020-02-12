<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/period'], function (Router $router) {
    $router->bind('period', function ($id) {
        return app('Modules\Period\Repositories\PeriodRepository')->find($id);
    });
    $router->get('periods', [
        'as' => 'admin.period.period.index',
        'uses' => 'PeriodController@index',
        'middleware' => 'can:period.periods.index'
    ]);
    $router->get('periods/hotel-campaigns', [
        'as' => 'admin.period.period.hotel.campaigns',
        'uses' => 'PeriodController@hotelCampaigns',
        'middleware' => 'can:period.periods.create'
    ]);
    $router->get('periods/create', [
        'as' => 'admin.period.period.create',
        'uses' => 'PeriodController@create',
        'middleware' => 'can:period.periods.create'
    ]);
    $router->post('periods', [
        'as' => 'admin.period.period.store',
        'uses' => 'PeriodController@store',
        'middleware' => 'can:period.periods.create'
    ]);
    $router->get('periods/{period}/edit', [
        'as' => 'admin.period.period.edit',
        'uses' => 'PeriodController@edit',
        'middleware' => 'can:period.periods.edit'
    ]);
    $router->put('periods/{period}', [
        'as' => 'admin.period.period.update',
        'uses' => 'PeriodController@update',
        'middleware' => 'can:period.periods.edit'
    ]);
    $router->delete('periods/{period}', [
        'as' => 'admin.period.period.destroy',
        'uses' => 'PeriodController@destroy',
        'middleware' => 'can:period.periods.destroy'
    ]);
// append

});
