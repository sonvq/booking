<?php

namespace Modules\Campaign\Repositories\Cache;

use Modules\Campaign\Repositories\CampaignRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCampaignDecorator extends BaseCacheDecorator implements CampaignRepository
{
    public function __construct(CampaignRepository $campaign)
    {
        parent::__construct();
        $this->entityName = 'campaign.campaigns';
        $this->repository = $campaign;
    }
}
