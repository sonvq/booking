<?php

namespace Modules\Booking\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingSurcharge
 * @package Modules\Booking\Entities
 */
class BookingSurcharge extends Model
{
    /**
     * @var string
     */
    protected $table = 'surcharge_bookings';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'surcharge_id',
        'quantity',
        'start_date',
        'end_date',
        'buy_price',
        'sell_price'
    ];
}
