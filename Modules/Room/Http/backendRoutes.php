<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' =>'/room'], function (Router $router) {
    $router->bind('room', function ($id) {
        return app('Modules\Room\Repositories\RoomRepository')->find($id);
    });
    $router->get('rooms/import', [
        'uses' => 'ImportController@importIndex',
        'as' => 'admin.room.room.import.index',
        'middleware' => 'can:room.rooms.import'
    ]);
    $router->post('rooms/import', [
        'uses' => 'ImportController@importCreate',
        'as' => 'admin.room.room.import.create',
        'middleware' => 'can:room.rooms.import'
    ]);

    $router->get('rooms', [
        'as' => 'admin.room.room.index',
        'uses' => 'RoomController@index',
        'middleware' => 'can:room.rooms.index'
    ]);
    $router->get('rooms/create', [
        'as' => 'admin.room.room.create',
        'uses' => 'RoomController@create',
        'middleware' => 'can:room.rooms.create'
    ]);
    $router->post('rooms', [
        'as' => 'admin.room.room.store',
        'uses' => 'RoomController@store',
        'middleware' => 'can:room.rooms.create'
    ]);
    $router->get('rooms/{room}/edit', [
        'as' => 'admin.room.room.edit',
        'uses' => 'RoomController@edit',
        'middleware' => 'can:room.rooms.edit'
    ]);
    $router->put('rooms/{room}', [
        'as' => 'admin.room.room.update',
        'uses' => 'RoomController@update',
        'middleware' => 'can:room.rooms.edit'
    ]);
    $router->delete('rooms/{room}', [
        'as' => 'admin.room.room.destroy',
        'uses' => 'RoomController@destroy',
        'middleware' => 'can:room.rooms.destroy'
    ]);
// append

});
