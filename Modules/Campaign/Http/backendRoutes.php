<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/campaign'], function (Router $router) {
    $router->bind('campaign', function ($id) {
        return app('Modules\Campaign\Repositories\CampaignRepository')->find($id);
    });
    $router->get('campaigns', [
        'as' => 'admin.campaign.campaign.index',
        'uses' => 'CampaignController@index',
        'middleware' => 'can:campaign.campaigns.index'
    ]);
    $router->get('campaigns/hotel-rooms', [
        'as' => 'admin.campaign.campaign.hotel.rooms',
        'uses' => 'CampaignController@hotelRooms',
        'middleware' => 'can:campaign.campaigns.create'
    ]);
    $router->get('campaigns/hotel-services', [
        'as' => 'admin.campaign.campaign.hotel.services',
        'uses' => 'CampaignController@hotelServices',
        'middleware' => 'can:campaign.campaigns.create'
    ]);
    $router->get('campaigns/hotel-surcharges', [
        'as' => 'admin.campaign.campaign.hotel.surcharges',
        'uses' => 'CampaignController@hotelSurcharges',
        'middleware' => 'can:campaign.campaigns.create'
    ]);
    $router->get('campaigns/create', [
        'as' => 'admin.campaign.campaign.create',
        'uses' => 'CampaignController@create',
        'middleware' => 'can:campaign.campaigns.create'
    ]);
    $router->post('campaigns', [
        'as' => 'admin.campaign.campaign.store',
        'uses' => 'CampaignController@store',
        'middleware' => 'can:campaign.campaigns.create'
    ]);
    $router->get('campaigns/{campaign}/edit', [
        'as' => 'admin.campaign.campaign.edit',
        'uses' => 'CampaignController@edit',
        'middleware' => 'can:campaign.campaigns.edit'
    ]);
    $router->put('campaigns/{campaign}', [
        'as' => 'admin.campaign.campaign.update',
        'uses' => 'CampaignController@update',
        'middleware' => 'can:campaign.campaigns.edit'
    ]);
    $router->delete('campaigns/{campaign}', [
        'as' => 'admin.campaign.campaign.destroy',
        'uses' => 'CampaignController@destroy',
        'middleware' => 'can:campaign.campaigns.destroy'
    ]);
// append

});
