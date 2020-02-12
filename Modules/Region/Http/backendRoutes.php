<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/region'], function (Router $router) {
    $router->bind('region', function ($id) {
        return app('Modules\Region\Repositories\RegionRepository')->find($id);
    });
    $router->get('regions', [
        'as' => 'admin.region.region.index',
        'uses' => 'RegionController@index',
        'middleware' => 'can:region.regions.index'
    ]);
    $router->get('regions/create', [
        'as' => 'admin.region.region.create',
        'uses' => 'RegionController@create',
        'middleware' => 'can:region.regions.create'
    ]);
    $router->post('regions', [
        'as' => 'admin.region.region.store',
        'uses' => 'RegionController@store',
        'middleware' => 'can:region.regions.create'
    ]);
    $router->get('regions/{region}/edit', [
        'as' => 'admin.region.region.edit',
        'uses' => 'RegionController@edit',
        'middleware' => 'can:region.regions.edit'
    ]);
    $router->put('regions/{region}', [
        'as' => 'admin.region.region.update',
        'uses' => 'RegionController@update',
        'middleware' => 'can:region.regions.edit'
    ]);
    $router->delete('regions/{region}', [
        'as' => 'admin.region.region.destroy',
        'uses' => 'RegionController@destroy',
        'middleware' => 'can:region.regions.destroy'
    ]);
// append

});
