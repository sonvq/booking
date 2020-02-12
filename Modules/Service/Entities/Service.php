<?php

namespace Modules\Service\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Service
 * @package Modules\Service\Entities
 */
class Service extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'service__services';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'amount',
        'change',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hotels()
    {
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_services', 'service_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns()
    {
        return $this->belongsToMany(\Modules\Campaign\Entities\Campaign::class, 'service_campaigns', 'service_id', 'campaign_id')->withTimestamps();
    }
}
