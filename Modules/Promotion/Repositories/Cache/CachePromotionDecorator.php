<?php

namespace Modules\Promotion\Repositories\Cache;

use Modules\Promotion\Repositories\PromotionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePromotionDecorator extends BaseCacheDecorator implements PromotionRepository
{
    public function __construct(PromotionRepository $promotion)
    {
        parent::__construct();
        $this->entityName = 'promotion.promotions';
        $this->repository = $promotion;
    }
}
