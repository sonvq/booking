<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/company'], function (Router $router) {
    $router->bind('company', function ($id) {
        return app('Modules\Company\Repositories\CompanyRepository')->find($id);
    });
    $router->get('companies', [
        'as' => 'admin.company.company.index',
        'uses' => 'CompanyController@index',
        'middleware' => 'can:company.companies.index'
    ]);
    $router->get('companies/create', [
        'as' => 'admin.company.company.create',
        'uses' => 'CompanyController@create',
        'middleware' => 'can:company.companies.create'
    ]);
    $router->post('companies', [
        'as' => 'admin.company.company.store',
        'uses' => 'CompanyController@store',
        'middleware' => 'can:company.companies.create'
    ]);
    $router->get('companies/{company}/edit', [
        'as' => 'admin.company.company.edit',
        'uses' => 'CompanyController@edit',
        'middleware' => 'can:company.companies.edit'
    ]);
    $router->put('companies/{company}', [
        'as' => 'admin.company.company.update',
        'uses' => 'CompanyController@update',
        'middleware' => 'can:company.companies.edit'
    ]);
    $router->delete('companies/{company}', [
        'as' => 'admin.company.company.destroy',
        'uses' => 'CompanyController@destroy',
        'middleware' => 'can:company.companies.destroy'
    ]);
// append

});
