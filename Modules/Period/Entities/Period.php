<?php

namespace Modules\Period\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Entities\BaseModel;

/**
 * Class Period
 * @package Modules\Period\Entities
 */
class Period extends BaseModel
{
    protected $table = 'period__periods';
    protected $fillable = [
        'name',
        'cod',
        'campaign_id'
    ];

    /**
     * @return BelongsToMany
     */
    public function hotels()
    {
        return $this->belongsToMany(\Modules\Hotel\Entities\Hotel::class, 'hotel_periods', 'period_id', 'hotel_id')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(\Modules\Country\Entities\Country::class, 'country_periods', 'period_id', 'country_id')->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function dates()
    {
        return $this->hasMany(PeriodDate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(\Modules\Campaign\Entities\Campaign::class);
    }
}
