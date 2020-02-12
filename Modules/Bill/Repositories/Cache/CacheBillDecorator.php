<?php

namespace Modules\Bill\Repositories\Cache;

use Modules\Bill\Repositories\BillRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBillDecorator extends BaseCacheDecorator implements BillRepository
{
    public function __construct(BillRepository $bill)
    {
        parent::__construct();
        $this->entityName = 'bill.bills';
        $this->repository = $bill;
    }
}
