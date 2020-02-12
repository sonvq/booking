<?php

namespace Modules\Booking\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingRoom
 * @package Modules\Booking\Entities
 */
class BookingRoom extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_bookings';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'room_id',
        'quantity',
        'start_date',
        'end_date',
        'buy_price',
        'sell_price'
    ];
}
