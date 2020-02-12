<?php

namespace Modules\Hotel\Repositories\Cache;

use Modules\Hotel\Repositories\HotelRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheHotelDecorator extends BaseCacheDecorator implements HotelRepository
{
    public function __construct(HotelRepository $hotel)
    {
        parent::__construct();
        $this->entityName = 'hotel.hotels';
        $this->repository = $hotel;
    }
}
