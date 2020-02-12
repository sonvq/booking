<?php

namespace Modules\Agency\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Agency
 * @package Modules\Agency\Entities
 */
class Agency extends BaseModel
{
    protected $table = 'agency__agencies';

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'description',
        'amount',
        'type',
        'change',
    ];
}
