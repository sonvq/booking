<?php

namespace Modules\Region\Repositories\Cache;

use Modules\Region\Repositories\RegionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRegionDecorator extends BaseCacheDecorator implements RegionRepository
{
    public function __construct(RegionRepository $region)
    {
        parent::__construct();
        $this->entityName = 'region.regions';
        $this->repository = $region;
    }
}
