<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/promotion'], function (Router $router) {
    $router->bind('promotion', function ($id) {
        return app('Modules\Promotion\Repositories\PromotionRepository')->find($id);
    });
    $router->get('promotions', [
        'as' => 'admin.promotion.promotion.index',
        'uses' => 'PromotionController@index',
        'middleware' => 'can:promotion.promotions.index'
    ]);
    $router->get('promotions/create', [
        'as' => 'admin.promotion.promotion.create',
        'uses' => 'PromotionController@create',
        'middleware' => 'can:promotion.promotions.create'
    ]);
    $router->post('promotions', [
        'as' => 'admin.promotion.promotion.store',
        'uses' => 'PromotionController@store',
        'middleware' => 'can:promotion.promotions.create'
    ]);
    $router->get('promotions/{promotion}/edit', [
        'as' => 'admin.promotion.promotion.edit',
        'uses' => 'PromotionController@edit',
        'middleware' => 'can:promotion.promotions.edit'
    ]);
    $router->put('promotions/{promotion}', [
        'as' => 'admin.promotion.promotion.update',
        'uses' => 'PromotionController@update',
        'middleware' => 'can:promotion.promotions.edit'
    ]);
    $router->delete('promotions/{promotion}', [
        'as' => 'admin.promotion.promotion.destroy',
        'uses' => 'PromotionController@destroy',
        'middleware' => 'can:promotion.promotions.destroy'
    ]);
// append

    $router->get('promotions/campaign-hotels', [
        'as' => 'admin.promotion.promotion.campaign.hotels',
        'uses' => 'PromotionController@campaignHotels',
        'middleware' => 'can:promotion.promotions.create'
    ]);

    $router->get('promotions/campaign-rooms', [
        'as' => 'admin.promotion.promotion.campaign.rooms',
        'uses' => 'PromotionController@campaignRooms',
        'middleware' => 'can:promotion.promotions.create'
    ]);
});
