<?php

namespace Modules\Booking\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingService
 * @package Modules\Booking\Entities
 */
class BookingService extends Model
{
    /**
     * @var string
     */
    protected $table = 'service_bookings';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'service_id',
        'quantity',
        'start_date',
        'end_date',
        'buy_price',
        'sell_price'
    ];
}
