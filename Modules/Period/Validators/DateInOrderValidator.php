<?php

namespace Modules\Period\Validators;

/**
 * Class DateInOrderValidator
 * @package Modules\Period\Validators
 */
class DateInOrderValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        if (count($parameters) !== 3) {
            return true;
        }
        $dateFormat = array_pop($parameters);
        foreach ($parameters as $parameter) {
            if (empty($value[$parameter]) || in_array(null, $value[$parameter], true)) {
                return true;
            }
        }

        list($firstKey, $secondKey) = $parameters;

        foreach ($value[$firstKey] as $key => $first_value) {
            $firstDate = strtotime(\DateTime::createFromFormat($dateFormat, $first_value)->format('Y-m-d'));
            $secondDate = strtotime(\DateTime::createFromFormat($dateFormat, $value[$secondKey][$key])->format('Y-m-d'));

            if ($firstDate > $secondDate) {
                return false;
            }
        }

        return true;
    }
}
