<?php

namespace Modules\Company\Entities;

use Modules\Core\Entities\BaseModel;

/**
 * Class Company
 * @package Modules\Company\Entities
 */
class Company extends BaseModel
{
    protected $table = 'company__companies';

    protected $fillable = [
        'name',
        'description',
        'amount_buy',
        'change_buy',
        'type_buy',
        'amount_sell',
        'change_sell',
        'type_sell',
    ];
}
