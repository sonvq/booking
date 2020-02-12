<?php

namespace Modules\Booking\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

/**
 * Class CreateBookingRequest
 * @package Modules\Booking\Http\Requests
 */
class CreateBookingRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'hotel_id' => 'required|exists:hotel__hotels,id',
            'agency_id' => 'required|exists:agency__agencies,id',
            'supplier_id' => 'exists:supplier__suppliers,id|nullable',
            'sale_id' => 'exists:users,id|nullable',
            'customer_id' => 'required|exists:customer__customers,id',
            'checkin_date' => 'required|date_format:d/m/Y|before:checkout_date',
            'checkout_date' => 'required|date_format:d/m/Y',
            'hotel_confirm_code' => 'max:12',
            'flight_code' => 'max:24',
            'campaign_id' => 'required|exists:campaign__campaigns,id',

            'room_id.*' => 'required|exists:room__rooms,id',
            'quantity.*' => 'required|numeric|min:1',
            'start_date.*' => 'required|date_format:d/m/Y|before:end_date.*|after_or_equal:checkin_date',
            'end_date.*' => 'required|date_format:d/m/Y|before_or_equal:checkout_date',
            'buy_price.*' => 'required|numeric|min:1',
            'sell_price.*' => 'required|numeric|min:1',
            'date_range' => [
                'booking_date_in_range',
            ],

            'service_id.*' => 'required|exists:service__services,id',
            'service_quantity.*' => 'required|numeric|min:1',
            'service_start_date.*' => 'required|date_format:d/m/Y|before:service_end_date.*|after_or_equal:checkin_date',
            'service_end_date.*' => 'required|date_format:d/m/Y|before_or_equal:checkout_date',
            'service_buy_price.*' => 'required|numeric|min:1',
            'service_sell_price.*' => 'required|numeric|min:1',

            'surcharge_id.*' => 'required|exists:surcharge__surcharges,id',
            'surcharge_quantity.*' => 'required|numeric|min:1',
            'surcharge_start_date.*' => 'required|date_format:d/m/Y|before:surcharge_end_date.*|after_or_equal:checkin_date',
            'surcharge_end_date.*' => 'required|date_format:d/m/Y|before_or_equal:checkout_date',
            'surcharge_buy_price.*' => 'required|numeric|min:1',
            'surcharge_sell_price.*' => 'required|numeric|min:1',

            'total_price' => 'required|numeric|min:1',
            'total_buy_price' => 'required|numeric|min:1',
            'total_sell_price' => 'required|numeric|min:1',
            'total_profit' => 'required|numeric|min:1'
        ];
    }

    /**
     * @return array
     */
    public function all()
    {
        $all = parent::all();

        $all['date_range']['start_date'] = !empty($all['start_date']) ? $all['start_date'] : null;
        $all['date_range']['end_date'] = !empty($all['end_date']) ? $all['end_date'] : null;
        $all['date_range']['checkin_date'] = !empty($all['checkin_date']) ? $all['checkin_date'] : null;
        $all['date_range']['checkout_date'] = !empty($all['checkout_date']) ? $all['checkout_date'] : null;

        $all['total_price'] = !empty($all['total_price']) ? (int) str_replace(',', '', $all['total_price']) : null;
        $all['total_buy_price'] = !empty($all['total_buy_price']) ? (int) str_replace(',', '', $all['total_buy_price']) : null;
        $all['total_sell_price'] = !empty($all['total_sell_price']) ? (int) str_replace(',', '', $all['total_sell_price']) : null;
        $all['total_profit'] = !empty($all['total_profit']) ? (int) str_replace(',', '', $all['total_profit']) : null;

        if (isset($all['buy_price']) && isset($all['sell_price'])) {
            foreach ($all['buy_price'] as $key => $value) {
                $all['buy_price'][$key] = (int) str_replace(',', '', $value);
            }
            foreach ($all['sell_price'] as $key => $value) {
                $all['sell_price'][$key] = (int) str_replace(',', '', $value);
            }
        }

        if (isset($all['service_buy_price']) && isset($all['service_sell_price'])) {
            foreach ($all['service_buy_price'] as $key => $value) {
                $all['service_buy_price'][$key] = (int)str_replace(',', '', $value);
            }
            foreach ($all['service_sell_price'] as $key => $value) {
                $all['service_sell_price'][$key] = (int)str_replace(',', '', $value);
            }
        }

        if (isset($all['surcharge_buy_price']) && isset($all['surcharge_sell_price'])) {
            foreach ($all['surcharge_buy_price'] as $key => $value) {
                $all['surcharge_buy_price'][$key] = (int)str_replace(',', '', $value);
            }
            foreach ($all['surcharge_sell_price'] as $key => $value) {
                $all['surcharge_sell_price'][$key] = (int)str_replace(',', '', $value);
            }
        }

        return $all;
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
            'hotel_id.required' => trans('booking::bookings.validation.hotel_id.required'),
            'hotel_id.exists' => trans('booking::bookings.validation.hotel_id.exists'),

            'agency_id.required' => trans('booking::bookings.validation.agency_id.required'),
            'agency_id.exists' => trans('booking::bookings.validation.agency_id.exists'),

            'supplier_id.required' => trans('booking::bookings.validation.supplier_id.required'),
            'supplier_id.exists' => trans('booking::bookings.validation.supplier_id.exists'),

            'sale_id.exists' => trans('booking::bookings.validation.sale_id.exists'),

            'customer_id.required' => trans('booking::bookings.validation.customer_id.required'),
            'customer_id.exists' => trans('booking::bookings.validation.customer_id.exists'),

            'checkin_date.required' => trans('booking::bookings.validation.checkin_date.required'),
            'checkin_date.date_format' => trans('booking::bookings.validation.checkin_date.date_format'),
            'checkin_date.before' => trans('booking::bookings.validation.checkin_date.before'),

            'checkout_date.required' => trans('booking::bookings.validation.checkout_date.required'),
            'checkout_date.date_format' => trans('booking::bookings.validation.checkout_date.date_format'),

            'hotel_confirm_code.max' => trans('booking::bookings.validation.hotel_confirm_code.max'),

            'flight_code.max' => trans('booking::bookings.validation.flight_code.max'),

            'campaign_id.required' => trans('booking::bookings.validation.campaign_id.required'),
            'campaign_id.exists' => trans('booking::bookings.validation.campaign_id.exists'),

            // For room rows
            'room_id.*.exists' => trans('booking::bookings.validation.room_id.exists'),
            'room_id.*.required' => trans('booking::bookings.validation.room_id.required'),

            'quantity.*.numeric' => trans('booking::bookings.validation.quantity.numeric'),
            'quantity.*.min' => trans('booking::bookings.validation.quantity.min'),
            'quantity.*.required' => trans('booking::bookings.validation.quantity.required'),

            'start_date.*.required' => trans('booking::bookings.validation.start_date.required'),
            'start_date.*.date_format' => trans('booking::bookings.validation.start_date.date_format'),
            'start_date.*.before' => trans('booking::bookings.validation.start_date.before'),
            'start_date.*.after_or_equal' => trans('booking::bookings.validation.start_date.after_or_equal'),

            'end_date.*.required' => trans('booking::bookings.validation.end_date.required'),
            'end_date.*.date_format' => trans('booking::bookings.validation.end_date.date_format'),
            'end_date.*.before_or_equal' => trans('booking::bookings.validation.end_date.before_or_equal'),

            'buy_price.*.numeric' => trans('booking::bookings.validation.buy_price.numeric'),
            'buy_price.*.min' => trans('booking::bookings.validation.buy_price.min'),
            'buy_price.*.required' => trans('booking::bookings.validation.buy_price.required'),

            'sell_price.*.numeric' => trans('booking::bookings.validation.sell_price.numeric'),
            'sell_price.*.min' => trans('booking::bookings.validation.sell_price.min'),
            'sell_price.*.required' => trans('booking::bookings.validation.sell_price.required'),

            'date_range.booking_date_in_range' => trans('booking::bookings.validation.date_range.booking_date_in_range'),

            // For service rows
            'service_id.*.exists' => trans('booking::bookings.validation.service_id.exists'),
            'service_id.*.required' => trans('booking::bookings.validation.service_id.required'),

            'service_quantity.*.numeric' => trans('booking::bookings.validation.quantity.numeric'),
            'service_quantity.*.min' => trans('booking::bookings.validation.quantity.min'),
            'service_quantity.*.required' => trans('booking::bookings.validation.quantity.required'),

            'service_start_date.*.required' => trans('booking::bookings.validation.start_date.required'),
            'service_start_date.*.date_format' => trans('booking::bookings.validation.start_date.date_format'),
            'service_start_date.*.before' => trans('booking::bookings.validation.start_date.before'),
            'service_start_date.*.after_or_equal' => trans('booking::bookings.validation.start_date.after_or_equal'),

            'service_end_date.*.required' => trans('booking::bookings.validation.end_date.required'),
            'service_end_date.*.date_format' => trans('booking::bookings.validation.end_date.date_format'),
            'service_end_date.*.before_or_equal' => trans('booking::bookings.validation.end_date.before_or_equal'),

            'service_buy_price.*.numeric' => trans('booking::bookings.validation.buy_price.numeric'),
            'service_buy_price.*.min' => trans('booking::bookings.validation.buy_price.min'),
            'service_buy_price.*.required' => trans('booking::bookings.validation.buy_price.required'),

            'service_sell_price.*.numeric' => trans('booking::bookings.validation.sell_price.numeric'),
            'service_sell_price.*.min' => trans('booking::bookings.validation.sell_price.min'),
            'service_sell_price.*.required' => trans('booking::bookings.validation.sell_price.required'),

            // For surcharge rows
            'surcharge_id.*.exists' => trans('booking::bookings.validation.surcharge_id.exists'),
            'surcharge_id.*.required' => trans('booking::bookings.validation.surcharge_id.required'),

            'surcharge_quantity.*.numeric' => trans('booking::bookings.validation.quantity.numeric'),
            'surcharge_quantity.*.min' => trans('booking::bookings.validation.quantity.min'),
            'surcharge_quantity.*.required' => trans('booking::bookings.validation.quantity.required'),

            'surcharge_start_date.*.required' => trans('booking::bookings.validation.start_date.required'),
            'surcharge_start_date.*.date_format' => trans('booking::bookings.validation.start_date.date_format'),
            'surcharge_start_date.*.before' => trans('booking::bookings.validation.start_date.before'),
            'surcharge_start_date.*.after_or_equal' => trans('booking::bookings.validation.start_date.after_or_equal'),

            'surcharge_end_date.*.required' => trans('booking::bookings.validation.end_date.required'),
            'surcharge_end_date.*.date_format' => trans('booking::bookings.validation.end_date.date_format'),
            'surcharge_end_date.*.before_or_equal' => trans('booking::bookings.validation.end_date.before_or_equal'),

            'surcharge_buy_price.*.numeric' => trans('booking::bookings.validation.buy_price.numeric'),
            'surcharge_buy_price.*.min' => trans('booking::bookings.validation.buy_price.min'),
            'surcharge_buy_price.*.required' => trans('booking::bookings.validation.buy_price.required'),

            'surcharge_sell_price.*.numeric' => trans('booking::bookings.validation.sell_price.numeric'),
            'surcharge_sell_price.*.min' => trans('booking::bookings.validation.sell_price.min'),
            'surcharge_sell_price.*.required' => trans('booking::bookings.validation.sell_price.required'),

            'total_price.numeric' => trans('booking::bookings.validation.total_price.numeric'),
            'total_price.min' => trans('booking::bookings.validation.total_price.min'),
            'total_price.required' => trans('booking::bookings.validation.total_price.required'),

            'total_buy_price.numeric' => trans('booking::bookings.validation.total_buy_price.numeric'),
            'total_buy_price.min' => trans('booking::bookings.validation.total_buy_price.min'),
            'total_buy_price.required' => trans('booking::bookings.validation.total_buy_price.required'),

            'total_sell_price.numeric' => trans('booking::bookings.validation.total_sell_price.numeric'),
            'total_sell_price.min' => trans('booking::bookings.validation.total_sell_price.min'),
            'total_sell_price.required' => trans('booking::bookings.validation.total_sell_price.required'),

            'total_profit.numeric' => trans('booking::bookings.validation.total_profit.numeric'),
            'total_profit.min' => trans('booking::bookings.validation.total_profit.min'),
            'total_profit.required' => trans('booking::bookings.validation.total_profit.required'),
        ];
    }
}
