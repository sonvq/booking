<?php

namespace Modules\Period\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PeriodDate
 * @package Modules\Period\Entities
 */
class PeriodDate extends Model
{
    protected $table = 'period_dates';
    protected $fillable = [
        'period_id',
        'start_date',
        'end_date'
    ];
}
