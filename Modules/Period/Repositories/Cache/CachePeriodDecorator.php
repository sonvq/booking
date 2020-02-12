<?php

namespace Modules\Period\Repositories\Cache;

use Modules\Period\Repositories\PeriodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePeriodDecorator extends BaseCacheDecorator implements PeriodRepository
{
    public function __construct(PeriodRepository $period)
    {
        parent::__construct();
        $this->entityName = 'period.periods';
        $this->repository = $period;
    }
}
