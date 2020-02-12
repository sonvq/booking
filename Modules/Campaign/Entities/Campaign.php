<?php

namespace Modules\Campaign\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Campaign
 * @package Modules\Campaign\Entities
 */
class Campaign extends BaseModel
{
    protected $table = 'campaign__campaigns';

    protected $fillable = [
        'name',
        'description',
        'amount',
        'change',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hotels()
    {
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_campaigns', 'campaign_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(\Modules\Room\Entities\Room::class, 'room_campaigns', 'campaign_id', 'room_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(\Modules\Service\Entities\Service::class, 'service_campaigns', 'campaign_id', 'service_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function surcharges()
    {
        return $this->belongsToMany(\Modules\Surcharge\Entities\Surcharge::class, 'surcharge_campaigns', 'campaign_id', 'surcharge_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function period()
    {
        return $this->belongsTo(\Modules\Campaign\Entities\Campaign::class);
    }
}


