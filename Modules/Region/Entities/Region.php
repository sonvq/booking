<?php

namespace Modules\Region\Entities;

use Modules\Core\Entities\BaseModel;

class Region extends BaseModel
{

    protected $table = 'region__regions';

    protected $fillable = [
        'name',
    ];
}
