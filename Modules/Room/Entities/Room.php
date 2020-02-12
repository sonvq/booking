<?php

namespace Modules\Room\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Room
 * @package Modules\Room\Entities
 */
class Room extends BaseModel
{
    protected $table = 'room__rooms';

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
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_rooms', 'room_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns()
    {
        return $this->belongsToMany(\Modules\Campaign\Entities\Campaign::class, 'room_campaigns', 'room_id', 'campaign_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany(\Modules\Promotion\Entities\Promotion::class, 'room_promotions', 'room_id', 'promotion_id')->withTimestamps();
    }
}

