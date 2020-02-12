<?php

namespace Modules\Receipt\Http\Requests;

use Modules\Booking\Entities\Booking;
use Modules\Receipt\Entities\Receipt;

/**
 * Class CreateReceiptRequest
 * @package Modules\Receipt\Http\Requests
 */
class CreateReceiptRequest extends BaseReceiptRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        $validationData = $this->validationData();
        $user = $this->user();
        $canChangeStatus = ($user->hasRoleSlug(config('asgard.user.config.role-list.admin', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.manager', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.accountant', '')));

        $booking = null;
        if (!empty($validationData['booking_id'])) {
            $booking = Booking::find($validationData['booking_id']);
        }
        $types = Receipt::type();
        $paymentTypes = Receipt::paymentType();
        $statuses = Receipt::status();

        array_shift($types);
        array_shift($paymentTypes);
        array_shift($statuses);

        if (!$canChangeStatus) {
            unset($statuses[Receipt::STATUS_CONFIRMED]);
        }
        $rules = [
            'booking_id' => 'exists:booking__bookings,id',
            'type' => 'required|in:' . implode(',', array_keys($types)),
            'payment_type' => [
                'required',
                'in:' . implode(',', array_keys($paymentTypes)),
            ],
            'amount' => 'required|min:1|numeric',
            'parent_id' => 'required_if:payment_type,' . Receipt::PAYMENT_TYPE_DEDUCT . '|exists:receipt__receipts,id|nullable',
            'status' => 'required|in:' . implode(',', array_keys($statuses)),
            'start_date' => 'required|date_format:d/m/Y'
        ];

        $rules = $this->addCustomRuleForDeductPaymentType($booking, $validationData, $rules);

        return $rules;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'booking_id.exists' => trans('receipt::receipts.validation.booking_id.exists'),

            'type.required' => trans('receipt::receipts.validation.type.required'),
            'type.in' => trans('receipt::receipts.validation.type.in'),

            'payment_type.required' => trans('receipt::receipts.validation.payment_type.required'),
            'payment_type.in' => trans('receipt::receipts.validation.payment_type.in'),

            'amount.numeric' => trans('receipt::receipts.validation.amount.numeric'),
            'amount.min' => trans('receipt::receipts.validation.amount.min'),
            'amount.required' => trans('receipt::receipts.validation.amount.required'),
            'amount.max' => trans('receipt::receipts.validation.amount.max'),

            'parent_id.exists' => trans('receipt::receipts.validation.parent_id.exists'),
            'parent_id.required_if' => trans('receipt::receipts.validation.parent_id.required_if'),
            'parent_id.invalid_deduct_amount' => trans('receipt::receipts.validation.parent_id.invalid_deduct_amount'),

            'status.required' => trans('receipt::receipts.validation.status.required'),
            'status.in' => trans('receipt::receipts.validation.status.in'),

            'start_date.required' => trans('receipt::receipts.validation.start_date.required'),
            'start_date.date_format' => trans('receipt::receipts.validation.start_date.date_format'),
        ];
    }
}
