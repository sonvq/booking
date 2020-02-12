<?php

namespace Modules\Surcharge\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Surcharge
 * @package Modules\Surcharge\Entities
 */
class Surcharge extends BaseModel
{
    protected $table = 'surcharge__surcharges';

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
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_surcharges', 'surcharge_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns()
    {
        return $this->belongsToMany(\Modules\Campaign\Entities\Campaign::class, 'surcharge_campaigns', 'surcharge_id', 'campaign_id')->withTimestamps();
    }
}
