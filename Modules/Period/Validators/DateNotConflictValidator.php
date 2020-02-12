<?php

namespace Modules\Period\Validators;

/**
 * Class DateNotConflictValidator
 * @package Modules\Media\Validators
 */
class DateNotConflictValidator
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
        array_multisort($value[$firstKey], $value[$secondKey]);
        foreach ($value[$firstKey] as $key => $firstValue) {
            if ($key < count($value[$firstKey]) - 1) {
                $startDate = strtotime(\DateTime::createFromFormat($dateFormat, $value[$firstKey][$key])->format('Y-m-d'));
                $endDate = strtotime(\DateTime::createFromFormat($dateFormat, $value[$secondKey][$key])->format('Y-m-d'));

                $nextStartDate = strtotime(\DateTime::createFromFormat($dateFormat, $value[$firstKey][$key + 1])->format('Y-m-d'));
                $nextEndDate = strtotime(\DateTime::createFromFormat($dateFormat, $value[$secondKey][$key + 1])->format('Y-m-d'));

                if (($startDate >= $nextStartDate && $startDate <= $nextEndDate)
                    || ($endDate >= $nextStartDate && $endDate <= $nextEndDate)
                    || ($startDate <= $nextStartDate && $endDate >= $nextEndDate)) {
                    return false;
                }
            }
        }

        return true;
    }
}
