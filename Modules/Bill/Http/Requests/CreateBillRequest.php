<?php

namespace Modules\Bill\Http\Requests;

use Modules\Bill\Entities\Bill;
use Modules\Booking\Entities\Booking;

/**
 * Class CreateBillRequest
 * @package Modules\Bill\Http\Requests
 */
class CreateBillRequest extends BaseBillRequest
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
        $types = Bill::type();
        $paymentTypes = Bill::paymentType();
        $statuses = Bill::status();

        array_shift($types);
        array_shift($paymentTypes);
        array_shift($statuses);

        if (!$canChangeStatus) {
            unset($statuses[Bill::STATUS_CONFIRMED]);
        }
        $rules = [
            'booking_id' => 'exists:booking__bookings,id',
            'type' => 'required|in:' . implode(',', array_keys($types)),
            'payment_type' => [
                'required',
                'in:' . implode(',', array_keys($paymentTypes)),
            ],
            'amount' => 'required|min:1|numeric',
            'parent_id' => 'required_if:payment_type,' . Bill::PAYMENT_TYPE_DEDUCT . '|exists:bill__bills,id|nullable',
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
            'booking_id.exists' => trans('bill::bills.validation.booking_id.exists'),

            'type.required' => trans('bill::bills.validation.type.required'),
            'type.in' => trans('bill::bills.validation.type.in'),

            'payment_type.required' => trans('bill::bills.validation.payment_type.required'),
            'payment_type.in' => trans('bill::bills.validation.payment_type.in'),

            'amount.numeric' => trans('bill::bills.validation.amount.numeric'),
            'amount.min' => trans('bill::bills.validation.amount.min'),
            'amount.required' => trans('bill::bills.validation.amount.required'),
            'amount.max' => trans('bill::bills.validation.amount.max'),

            'parent_id.exists' => trans('bill::bills.validation.parent_id.exists'),
            'parent_id.required_if' => trans('bill::bills.validation.parent_id.required_if'),
            'parent_id.invalid_deduct_amount' => trans('bill::bills.validation.parent_id.invalid_deduct_amount'),

            'status.required' => trans('bill::bills.validation.status.required'),
            'status.in' => trans('bill::bills.validation.status.in'),

            'start_date.required' =>  trans('bill::bills.validation.start_date.required'),
            'start_date.date_format' =>  trans('bill::bills.validation.start_date.date_format'),
        ];
    }
}
