<?php

namespace Modules\Audit\Repositories\Cache;

use Modules\Audit\Repositories\AuditRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAuditDecorator extends BaseCacheDecorator implements AuditRepository
{
    public function __construct(AuditRepository $audit)
    {
        parent::__construct();
        $this->entityName = 'audit.audits';
        $this->repository = $audit;
    }
}
