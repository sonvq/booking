<?php

namespace Modules\Hotel\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Hotel
 * @package Modules\Hotel\Entities
 */
class Hotel extends BaseModel
{
    protected $table = 'hotel__hotels';

    protected $fillable = [
        'name',
        'description',
        'email',
        'telephone',
        'region_id',
        'company_id',
        'amount_buy',
        'change_buy',
        'type_buy',
        'amount_sell',
        'change_sell',
        'type_sell',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(\Modules\Company\Entities\Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(\Modules\Region\Entities\Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(\Modules\Room\Entities\Room::class, 'hotel_rooms', 'hotel_id', 'room_id')->withTimestamps();
    }
}
