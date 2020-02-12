<?php

namespace Modules\Promotion\Validators;

use Modules\Promotion\Entities\Promotion;

/**
 * Class PromotionDateNotConflictValidator
 * @package Modules\Promotion\Validators
 */
class PromotionDateNotConflictValidator
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
            if (empty($value)) {
                return true;
            }
        }

        $objectId = null;
        if (!empty($parameters[0])) {
            $objectId = $parameters[0];
        }

        $startDate = strtotime(\DateTime::createFromFormat('d/m/Y', $values['start_date'])->format('Y-m-d'));
        $endDate = strtotime(\DateTime::createFromFormat('d/m/Y', $values['end_date'])->format('Y-m-d'));

        // Find existing Promotion with the same agency, campaign, hotel and room
        $existingPromotionQuery = Promotion::whereHas('hotels', function ($q) use ($values) {
            $q->whereIn('id', $values['hotel_id']);
        })
            ->whereHas('agencies', function ($q) use ($values) {
                $q->whereIn('id', $values['agency_id']);
            })
            ->whereHas('rooms', function ($q) use ($values) {
                $q->whereIn('id', $values['room_id']);
            })
            ->where('campaign_id', $values['campaign_id']);

        // For case editing
        if ($objectId !== null) {
            $existingPromotionQuery = $existingPromotionQuery->where('id', '!=' , $objectId);
        }

        $existingPromotions = $existingPromotionQuery->get();

        if (count($existingPromotions) > 0) {
            foreach ($existingPromotions as $existingPromotion) {

                $compareStartDate = strtotime($existingPromotion->start_date);
                $compareEndDate = strtotime($existingPromotion->end_date);

                if (($startDate >= $compareStartDate && $startDate <= $compareEndDate)
                    || ($endDate >= $compareStartDate && $endDate <= $compareEndDate)
                    || ($startDate <= $compareStartDate && $endDate >= $compareEndDate)) {
                    return false;
                }
            }
        }

        return true;
    }
}
