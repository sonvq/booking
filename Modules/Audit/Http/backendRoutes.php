<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/audit'], function (Router $router) {
    $router->bind('audit', function ($id) {
        return app('Modules\Audit\Repositories\AuditRepository')->find($id);
    });
    $router->get('audits', [
        'as' => 'admin.audit.audit.index',
        'uses' => 'AuditController@index',
        'middleware' => 'can:audit.audits.index'
    ]);
    $router->get('audits/create', [
        'as' => 'admin.audit.audit.create',
        'uses' => 'AuditController@create',
        'middleware' => 'can:audit.audits.create'
    ]);
    $router->post('audits', [
        'as' => 'admin.audit.audit.store',
        'uses' => 'AuditController@store',
        'middleware' => 'can:audit.audits.create'
    ]);
    $router->get('audits/{audit}/edit', [
        'as' => 'admin.audit.audit.edit',
        'uses' => 'AuditController@edit',
        'middleware' => 'can:audit.audits.edit'
    ]);
    $router->put('audits/{audit}', [
        'as' => 'admin.audit.audit.update',
        'uses' => 'AuditController@update',
        'middleware' => 'can:audit.audits.edit'
    ]);
    $router->delete('audits/{audit}', [
        'as' => 'admin.audit.audit.destroy',
        'uses' => 'AuditController@destroy',
        'middleware' => 'can:audit.audits.destroy'
    ]);
// append

});
