<?php

namespace Modules\Period\Validators;

use Modules\Period\Entities\Period;

/**
 * Class DateNotConflictOtherValidator
 * @package Modules\Period\Validators
 */
class DateNotConflictOtherValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        if (count($parameters) < 5) {
            return true;
        }
        $firstKey = $parameters[0];
        $secondKey = $parameters[1];
        $dateFormat = $parameters[2];
        $firstHotelId = $parameters[3];
        $firstCountryId = $parameters[4];
        $objectId = null;
        if (!empty($parameters[5])) {
            $objectId = $parameters[5];
        }

        if ($firstHotelId === '0') {
            return true;
        }

        if (empty($value[$firstKey]) || in_array(null, $value[$firstKey], true)) {
            return true;
        }
        if (empty($value[$secondKey]) || in_array(null, $value[$secondKey], true)) {
            return true;
        }

        $existingPeriodQuery = Period::whereHas('hotels', function($q) use($firstHotelId) {
            $q->where('hotel_id', $firstHotelId);
        });


        if ($firstCountryId !== '0') {
            $existingPeriodQuery = $existingPeriodQuery->whereHas('countries', function($q) use($firstCountryId) {
                $q->where('country_id', $firstCountryId);
            });
        } else {
            $existingPeriodQuery = $existingPeriodQuery->has('countries', '=', 0);
        }

        if ($objectId !== null) {
            $existingPeriodQuery = $existingPeriodQuery->where('id', '!=' , $objectId);
        }

        $existingPeriods = $existingPeriodQuery->get();
        if (count($existingPeriods) > 0) {
            foreach ($existingPeriods as $existingPeriod) {
                $datePeriods = $existingPeriod->dates()->get()->toArray();
                foreach ($datePeriods as $date) {
                    $value[$firstKey][] = \DateTime::createFromFormat('Y-m-d', $date['start_date'])->format($dateFormat);
                    $value[$secondKey][] = \DateTime::createFromFormat('Y-m-d', $date['end_date'])->format($dateFormat);
                }
            }
        }
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
