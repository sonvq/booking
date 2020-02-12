<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/hotel'], function (Router $router) {
    $router->bind('hotel', function ($id) {
        return app('Modules\Hotel\Repositories\HotelRepository')->find($id);
    });
    $router->get('hotels', [
        'as' => 'admin.hotel.hotel.index',
        'uses' => 'HotelController@index',
        'middleware' => 'can:hotel.hotels.index'
    ]);
    $router->get('hotels/create', [
        'as' => 'admin.hotel.hotel.create',
        'uses' => 'HotelController@create',
        'middleware' => 'can:hotel.hotels.create'
    ]);
    $router->post('hotels', [
        'as' => 'admin.hotel.hotel.store',
        'uses' => 'HotelController@store',
        'middleware' => 'can:hotel.hotels.create'
    ]);
    $router->get('hotels/{hotel}/edit', [
        'as' => 'admin.hotel.hotel.edit',
        'uses' => 'HotelController@edit',
        'middleware' => 'can:hotel.hotels.edit'
    ]);
    $router->put('hotels/{hotel}', [
        'as' => 'admin.hotel.hotel.update',
        'uses' => 'HotelController@update',
        'middleware' => 'can:hotel.hotels.edit'
    ]);
    $router->delete('hotels/{hotel}', [
        'as' => 'admin.hotel.hotel.destroy',
        'uses' => 'HotelController@destroy',
        'middleware' => 'can:hotel.hotels.destroy'
    ]);
// append

});
