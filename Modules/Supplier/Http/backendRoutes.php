<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/supplier'], function (Router $router) {
    $router->bind('supplier', function ($id) {
        return app('Modules\Supplier\Repositories\SupplierRepository')->find($id);
    });
    $router->get('suppliers', [
        'as' => 'admin.supplier.supplier.index',
        'uses' => 'SupplierController@index',
        'middleware' => 'can:supplier.suppliers.index'
    ]);
    $router->get('suppliers/create', [
        'as' => 'admin.supplier.supplier.create',
        'uses' => 'SupplierController@create',
        'middleware' => 'can:supplier.suppliers.create'
    ]);
    $router->post('suppliers', [
        'as' => 'admin.supplier.supplier.store',
        'uses' => 'SupplierController@store',
        'middleware' => 'can:supplier.suppliers.create'
    ]);
    $router->get('suppliers/{supplier}/edit', [
        'as' => 'admin.supplier.supplier.edit',
        'uses' => 'SupplierController@edit',
        'middleware' => 'can:supplier.suppliers.edit'
    ]);
    $router->put('suppliers/{supplier}', [
        'as' => 'admin.supplier.supplier.update',
        'uses' => 'SupplierController@update',
        'middleware' => 'can:supplier.suppliers.edit'
    ]);
    $router->delete('suppliers/{supplier}', [
        'as' => 'admin.supplier.supplier.destroy',
        'uses' => 'SupplierController@destroy',
        'middleware' => 'can:supplier.suppliers.destroy'
    ]);
// append

});
