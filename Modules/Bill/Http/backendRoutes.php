<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/bill'], function (Router $router) {
    $router->bind('bill', function ($id) {
        return app('Modules\Bill\Repositories\BillRepository')->find($id);
    });
    $router->bind('booking', function ($id) {
        return app('Modules\Booking\Repositories\BookingRepository')->find($id);
    });
    $router->get('bills', [
        'as' => 'admin.bill.bill.index',
        'uses' => 'BillController@index',
        'middleware' => 'can:bill.bills.index'
    ]);
    $router->get('bills/create/{booking?}', [
        'as' => 'admin.bill.bill.create',
        'uses' => 'BillController@create',
        'middleware' => 'can:bill.bills.create'
    ]);
    $router->post('bills', [
        'as' => 'admin.bill.bill.store',
        'uses' => 'BillController@store',
        'middleware' => 'can:bill.bills.create'
    ]);
    $router->get('bills/{bill}/edit', [
        'as' => 'admin.bill.bill.edit',
        'uses' => 'BillController@edit',
        'middleware' => 'can:bill.bills.edit'
    ]);
    $router->put('bills/{bill}', [
        'as' => 'admin.bill.bill.update',
        'uses' => 'BillController@update',
        'middleware' => 'can:bill.bills.edit'
    ]);
    $router->delete('bills/{bill}', [
        'as' => 'admin.bill.bill.destroy',
        'uses' => 'BillController@destroy',
        'middleware' => 'can:bill.bills.destroy'
    ]);
// append
});
