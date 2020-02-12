<?php

namespace Modules\Surcharge\Repositories\Cache;

use Modules\Surcharge\Repositories\SurchargeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSurchargeDecorator extends BaseCacheDecorator implements SurchargeRepository
{
    public function __construct(SurchargeRepository $surcharge)
    {
        parent::__construct();
        $this->entityName = 'surcharge.surcharges';
        $this->repository = $surcharge;
    }
}
