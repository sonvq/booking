<?php

namespace Modules\Bill\Validators;

/**
 * Class InvalidDeductAmountValidator
 * @package Modules\Bill\Validators
 */
class InvalidDeductAmountValidator
{
    /**
     * @param $attribute
     * @param $values
     * @param $parameters
     * @return bool
     */
    public function validate($attribute, $values, $parameters)
    {
        return false;
    }
}
