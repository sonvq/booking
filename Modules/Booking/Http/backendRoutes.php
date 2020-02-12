<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/booking'], function (Router $router) {
    /**
     * BOOKING ROUTE
     */
    $router->bind('booking', function ($id) {
        return app('Modules\Booking\Repositories\BookingRepository')->find($id);
    });
    $router->get('bookings', [
        'as' => 'admin.booking.booking.index',
        'uses' => 'BookingController@index',
        'middleware' => 'can:booking.bookings.index'
    ]);
    $router->get('bookings/create', [
        'as' => 'admin.booking.booking.create',
        'uses' => 'BookingController@create',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/hotel-campaigns', [
        'as' => 'admin.booking.booking.hotel.campaigns',
        'uses' => 'BookingController@hotelCampaigns',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/sell-buy-price', [
        'as' => 'admin.booking.booking.sell.buy.price',
        'uses' => 'BookingController@sellBuyPrice',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/hotel-rooms', [
        'as' => 'admin.booking.booking.hotel.rooms',
        'uses' => 'BookingController@hotelRooms',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/hotel-services', [
        'as' => 'admin.booking.booking.hotel.services',
        'uses' => 'BookingController@hotelServices',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/hotel-surcharges', [
        'as' => 'admin.booking.booking.hotel.surcharges',
        'uses' => 'BookingController@hotelSurcharges',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/report', [
        'as' => 'admin.booking.booking.report.index',
        'uses' => 'BookingReportController@index',
        'middleware' => 'can:booking.bookings.report'
    ]);
    $router->post('bookings/report', [
        'uses' => 'BookingReportController@create',
        'as' => 'admin.booking.booking.report.create',
        'middleware' => 'can:booking.bookings.report'
    ]);

    $router->get('bookings/financial', [
        'as' => 'admin.booking.booking.financial.index',
        'uses' => 'FinancialReportController@index',
        'middleware' => 'can:booking.bookings.financial'
    ]);
    $router->post('bookings/financial', [
        'uses' => 'FinancialReportController@create',
        'as' => 'admin.booking.booking.financial.create',
        'middleware' => 'can:booking.bookings.financial'
    ]);

    $router->get('bookings/update-status', [
        'as' => 'admin.booking.booking.update.status',
        'uses' => 'BookingController@updateStatus',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/cod', [
        'as' => 'admin.booking.booking.cod',
        'uses' => 'BookingController@cod',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->post('bookings', [
        'as' => 'admin.booking.booking.store',
        'uses' => 'BookingController@store',
        'middleware' => 'can:booking.bookings.create'
    ]);
    $router->get('bookings/{booking}/edit', [
        'as' => 'admin.booking.booking.edit',
        'uses' => 'BookingController@edit',
        'middleware' => 'can:booking.bookings.edit'
    ]);
    $router->get('bookings/{booking}/email', [
        'as' => 'admin.booking.booking.email',
        'uses' => 'BookingController@email',
        'middleware' => 'can:booking.bookings.email'
    ]);
    $router->post('bookings/{booking}/email', [
        'as' => 'admin.booking.booking.send',
        'uses' => 'BookingController@send',
        'middleware' => 'can:booking.bookings.email'
    ]);
    $router->put('bookings/{booking}', [
        'as' => 'admin.booking.booking.update',
        'uses' => 'BookingController@update',
        'middleware' => 'can:booking.bookings.edit'
    ]);
    $router->delete('bookings/{booking}', [
        'as' => 'admin.booking.booking.destroy',
        'uses' => 'BookingController@destroy',
        'middleware' => 'can:booking.bookings.destroy'
    ]);
// append

});
