<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/surcharge'], function (Router $router) {
    $router->bind('surcharge', function ($id) {
        return app('Modules\Surcharge\Repositories\SurchargeRepository')->find($id);
    });
    $router->get('surcharges/import', [
        'uses' => 'ImportController@importIndex',
        'as' => 'admin.surcharge.surcharge.import.index',
        'middleware' => 'can:surcharge.surcharges.import'
    ]);
    $router->post('surcharges/import', [
        'uses' => 'ImportController@importCreate',
        'as' => 'admin.surcharge.surcharge.import.create',
        'middleware' => 'can:surcharge.surcharges.import'
    ]);
    $router->get('surcharges', [
        'as' => 'admin.surcharge.surcharge.index',
        'uses' => 'SurchargeController@index',
        'middleware' => 'can:surcharge.surcharges.index'
    ]);
    $router->get('surcharges/create', [
        'as' => 'admin.surcharge.surcharge.create',
        'uses' => 'SurchargeController@create',
        'middleware' => 'can:surcharge.surcharges.create'
    ]);
    $router->post('surcharges', [
        'as' => 'admin.surcharge.surcharge.store',
        'uses' => 'SurchargeController@store',
        'middleware' => 'can:surcharge.surcharges.create'
    ]);
    $router->get('surcharges/{surcharge}/edit', [
        'as' => 'admin.surcharge.surcharge.edit',
        'uses' => 'SurchargeController@edit',
        'middleware' => 'can:surcharge.surcharges.edit'
    ]);
    $router->put('surcharges/{surcharge}', [
        'as' => 'admin.surcharge.surcharge.update',
        'uses' => 'SurchargeController@update',
        'middleware' => 'can:surcharge.surcharges.edit'
    ]);
    $router->delete('surcharges/{surcharge}', [
        'as' => 'admin.surcharge.surcharge.destroy',
        'uses' => 'SurchargeController@destroy',
        'middleware' => 'can:surcharge.surcharges.destroy'
    ]);
// append

});
