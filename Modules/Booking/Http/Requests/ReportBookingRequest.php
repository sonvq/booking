<?php

namespace Modules\Booking\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

/**
 * Class ReportBookingRequest
 * @package Modules\Booking\Http\Requests
 */
class ReportBookingRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required|date_format:d/m/Y|before:end_date',
            'end_date' => 'required|date_format:d/m/Y',
            'report_type' => 'required',
        ];
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
            'start_date.required' => trans('booking::bookings.validation.start_date.required'),
            'start_date.date_format' => trans('booking::bookings.validation.start_date.date_format'),
            'start_date.before' => trans('booking::bookings.validation.start_date.before'),

            'end_date.required' => trans('booking::bookings.validation.end_date.required'),
            'end_date.date_format' => trans('booking::bookings.validation.end_date.date_format'),

            'report_type.required' => trans('booking::bookings.validation.report_type.required'),
        ];
    }
}
