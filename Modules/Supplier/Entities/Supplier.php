<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier__suppliers';

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
