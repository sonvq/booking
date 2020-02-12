<?php

namespace Modules\Supplier\Repositories\Cache;

use Modules\Supplier\Repositories\SupplierRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSupplierDecorator extends BaseCacheDecorator implements SupplierRepository
{
    public function __construct(SupplierRepository $supplier)
    {
        parent::__construct();
        $this->entityName = 'supplier.suppliers';
        $this->repository = $supplier;
    }
}
