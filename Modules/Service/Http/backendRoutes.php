<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/service'], function (Router $router) {
    $router->bind('service', function ($id) {
        return app('Modules\Service\Repositories\ServiceRepository')->find($id);
    });
    $router->get('services/import', [
        'uses' => 'ImportController@importIndex',
        'as' => 'admin.service.service.import.index',
        'middleware' => 'can:service.services.import'
    ]);
    $router->post('services/import', [
        'uses' => 'ImportController@importCreate',
        'as' => 'admin.service.service.import.create',
        'middleware' => 'can:service.services.import'
    ]);

    $router->get('services', [
        'as' => 'admin.service.service.index',
        'uses' => 'ServiceController@index',
        'middleware' => 'can:service.services.index'
    ]);
    $router->get('services/create', [
        'as' => 'admin.service.service.create',
        'uses' => 'ServiceController@create',
        'middleware' => 'can:service.services.create'
    ]);
    $router->post('services', [
        'as' => 'admin.service.service.store',
        'uses' => 'ServiceController@store',
        'middleware' => 'can:service.services.create'
    ]);
    $router->get('services/{service}/edit', [
        'as' => 'admin.service.service.edit',
        'uses' => 'ServiceController@edit',
        'middleware' => 'can:service.services.edit'
    ]);
    $router->put('services/{service}', [
        'as' => 'admin.service.service.update',
        'uses' => 'ServiceController@update',
        'middleware' => 'can:service.services.edit'
    ]);
    $router->delete('services/{service}', [
        'as' => 'admin.service.service.destroy',
        'uses' => 'ServiceController@destroy',
        'middleware' => 'can:service.services.destroy'
    ]);
// append

});
