<?php

namespace Modules\Room\Repositories\Cache;

use Modules\Room\Repositories\RoomRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRoomDecorator extends BaseCacheDecorator implements RoomRepository
{
    public function __construct(RoomRepository $room)
    {
        parent::__construct();
        $this->entityName = 'room.rooms';
        $this->repository = $room;
    }
}
