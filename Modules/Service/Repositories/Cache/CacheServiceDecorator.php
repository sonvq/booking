<?php

namespace Modules\Service\Repositories\Cache;

use Modules\Service\Repositories\ServiceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceDecorator extends BaseCacheDecorator implements ServiceRepository
{
    public function __construct(ServiceRepository $service)
    {
        parent::__construct();
        $this->entityName = 'service.services';
        $this->repository = $service;
    }
}
