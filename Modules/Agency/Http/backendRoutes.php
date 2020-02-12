<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/agency'], function (Router $router) {
    $router->bind('agency', function ($id) {
        return app('Modules\Agency\Repositories\AgencyRepository')->find($id);
    });
    $router->get('agencies', [
        'as' => 'admin.agency.agency.index',
        'uses' => 'AgencyController@index',
        'middleware' => 'can:agency.agencies.index'
    ]);
    $router->get('agencies/create', [
        'as' => 'admin.agency.agency.create',
        'uses' => 'AgencyController@create',
        'middleware' => 'can:agency.agencies.create'
    ]);
    $router->post('agencies', [
        'as' => 'admin.agency.agency.store',
        'uses' => 'AgencyController@store',
        'middleware' => 'can:agency.agencies.create'
    ]);
    $router->get('agencies/{agency}/edit', [
        'as' => 'admin.agency.agency.edit',
        'uses' => 'AgencyController@edit',
        'middleware' => 'can:agency.agencies.edit'
    ]);
    $router->put('agencies/{agency}', [
        'as' => 'admin.agency.agency.update',
        'uses' => 'AgencyController@update',
        'middleware' => 'can:agency.agencies.edit'
    ]);
    $router->delete('agencies/{agency}', [
        'as' => 'admin.agency.agency.destroy',
        'uses' => 'AgencyController@destroy',
        'middleware' => 'can:agency.agencies.destroy'
    ]);
// append

});
