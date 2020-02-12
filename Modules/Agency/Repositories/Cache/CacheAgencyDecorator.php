<?php

namespace Modules\Agency\Repositories\Cache;

use Modules\Agency\Repositories\AgencyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAgencyDecorator extends BaseCacheDecorator implements AgencyRepository
{
    public function __construct(AgencyRepository $agency)
    {
        parent::__construct();
        $this->entityName = 'agency.agencies';
        $this->repository = $agency;
    }
}
