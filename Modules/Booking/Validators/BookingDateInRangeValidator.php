<?php

namespace Modules\Booking\Validators;

use Carbon\CarbonPeriod;

/**
 * Class BookingDateInRangeValidator
 * @package Modules\Booking\Validators
 */
class BookingDateInRangeValidator
{
    /**
     * @param $attribute
     * @param $values
     * @param $parameters
     * @return bool
     */
    public function validate($attribute, $values, $parameters)
    {
        foreach ($values as $value) {
            if (empty($value) || (is_array($value) && in_array(null, $value, true))) {
                return true;
            }
        }
        $checkinDate = \DateTime::createFromFormat('d/m/Y', $values['checkin_date'])->format('Y-m-d');
        $checkoutDate = \DateTime::createFromFormat('d/m/Y', $values['checkout_date']);

        $modifyString = '-1 day';
        $checkoutDate->modify($modifyString)->format('Y-m-d');

        $period = CarbonPeriod::create($checkinDate, $checkoutDate);

        $dateRangeCheckinCheckout = [];
        foreach ($period as $date) {
            /** @var \Datetime $date */
            $dateRangeCheckinCheckout[] = $date->format('Y-m-d');
        }

        $dateRangeStartDateEndDate = [];
        foreach ($values['start_date'] as $key => $startDate) {
            $startDateString = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDateString = \DateTime::createFromFormat('d/m/Y', $values['end_date'][$key]);
            $endDateString->modify($modifyString)->format('Y-m-d');

            $period = CarbonPeriod::create($startDateString, $endDateString);
            foreach ($period as $date) {
                /** @var \Datetime $date */
                $dateRangeStartDateEndDate[] = $date->format('Y-m-d');
            }
        }

        $dateRangeStartDateEndDate = array_unique($dateRangeStartDateEndDate);

        return !(count($dateRangeStartDateEndDate) < count($dateRangeCheckinCheckout));
    }
}
