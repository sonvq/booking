<?php

namespace Modules\Promotion\Validators;

use Modules\Campaign\Entities\Campaign;

/**
 * Class PromotionDateNotConflictCampaignDateValidator
 * @package Modules\Promotion\Validators
 */
class PromotionDateNotConflictCampaignDateValidator
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

        $startDate = strtotime(\DateTime::createFromFormat('d/m/Y', $values['start_date'])->format('Y-m-d'));
        $endDate = strtotime(\DateTime::createFromFormat('d/m/Y', $values['end_date'])->format('Y-m-d'));

        // Find existing Promotion with the same agency, campaign, hotel and room
        $campaign = Campaign::where('id', $values['campaign_id'])->first();

        if ($campaign) {
            $compareStartDate = strtotime($campaign->start_date);
            $compareEndDate = strtotime($campaign->end_date);

            return $compareStartDate <= $startDate && $endDate <= $compareEndDate;
        }

        return true;
    }
}
