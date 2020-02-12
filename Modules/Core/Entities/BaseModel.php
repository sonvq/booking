<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class BaseModel
 * @package Modules\Core\Entities
 */
class BaseModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const CHANGE_INCREASE = 'increase';
    const CHANGE_DECREASE = 'decrease';

    const TYPE_NUMBER = 'number';
    const TYPE_PERCENTAGE = 'percentage';

    /**
     * @return array
     */
    public static function change()
    {
        return [
            '' => trans('core::core.form.change_value.empty_option'),
            self::CHANGE_INCREASE => trans('core::core.form.change_value.' . self::CHANGE_INCREASE),
            self::CHANGE_DECREASE => trans('core::core.form.change_value.' . self::CHANGE_DECREASE),
        ];
    }

    /**
     * @return array
     */
    public static function type()
    {
        return [
            '' => trans('core::core.form.type_value.empty_option'),
            self::TYPE_NUMBER => trans('core::core.form.type_value.' . self::TYPE_NUMBER),
            self::TYPE_PERCENTAGE => trans('core::core.form.type_value.' . self::TYPE_PERCENTAGE),
        ];
    }
}
