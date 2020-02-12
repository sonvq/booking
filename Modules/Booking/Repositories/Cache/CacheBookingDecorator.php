<?php

namespace Modules\Booking\Repositories\Cache;

use Modules\Booking\Repositories\BookingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBookingDecorator extends BaseCacheDecorator implements BookingRepository
{
    public function __construct(BookingRepository $booking)
    {
        parent::__construct();
        $this->entityName = 'booking.bookings';
        $this->repository = $booking;
    }
}
