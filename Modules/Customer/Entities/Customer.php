<?php

namespace Modules\Customer\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Customer
 * @package Modules\Customer\Entities
 */
class Customer extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'customer__customers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'country_id',
        'telephone',
        'identity',
        'birthday',
        'gender',
        'appointment',
        'note',
        'author_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(\Modules\Country\Entities\Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class);
    }

    public function booking()
    {
        return $this->hasMany('Modules\Booking\Entities\Booking');
    }
}
