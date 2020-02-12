<?php

namespace Modules\Promotion\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Promotion
 * @package Modules\Promotion\Entities
 */
class Promotion extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'promotion__promotions';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'amount',
        'change',
        'type',
        'campaign_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(\Modules\Campaign\Entities\Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agencies()
    {
        return $this->belongsToMany(\Modules\Agency\Entities\Agency::class, 'agency_promotions', 'promotion_id', 'agency_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hotels()
    {
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_promotions', 'promotion_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(\Modules\Room\Entities\Room::class, 'room_promotions', 'promotion_id', 'room_id')->withTimestamps();
    }
}
