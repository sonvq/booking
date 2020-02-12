<?php

namespace Modules\Period\Validators;

/**
 * Class NotContainNullValidator
 * @package Modules\Period\Validators
 */
class NotContainNullValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        return !in_array(null, $value, true);
    }
}
