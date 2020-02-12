<?php

namespace Modules\Period\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePeriodRequest extends BaseFormRequest
{
    public function rules()
    {
//        $period = $this->route('period');
//        $validationData = $this->validationData();
//        $firstHotelId = 0;
//        if (!empty($validationData['hotel_id']) && count($validationData['hotel_id']) > 0) {
//            $firstHotelId = $validationData['hotel_id'][0];
//        }
//        $firstCountryId = 0;
//        if (!empty($validationData['country_id']) && count($validationData['country_id']) > 0) {
//            $firstCountryId = $validationData['country_id'][0];
//        }

        return [
            'hotel_id' => 'required|array',
            'campaign_id' => 'required',
            'country_id' => 'array',
            'name' => 'required|max:100',
            'cod' => 'required|numeric|min:1',
            'start_date' => 'required|array|not_contain_null',
            'end_date' => 'required|array|not_contain_null',
            'date_range' => [
                'date_not_conflict:start_date,end_date,d/m/Y',
                'date_in_order:start_date,end_date,d/m/Y',
//                'date_not_conflict_other:start_date,end_date,d/m/Y,' . $firstHotelId . ',' . $firstCountryId . ',' . $period->id
            ]
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function all()
    {
        $all = parent::all();

        $all['date_range']['start_date'] = $all['start_date'];
        $all['date_range']['end_date'] = $all['end_date'];

        return $all;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'hotel_id.required' => trans('period::periods.validation.hotel_id.required'),
            'hotel_id.array' => trans('period::periods.validation.hotel_id.array'),

            'campaign_id.required' => trans('period::periods.validation.campaign_id.required'),

            'country_id.array' => trans('period::periods.validation.country_id.array'),

            'name.required' => trans('period::periods.validation.name.required'),
            'name.max' => trans('period::periods.validation.name.max'),

            'cod.required' => trans('period::periods.validation.cod.required'),
            'cod.numeric' => trans('period::periods.validation.cod.numeric'),
            'cod.min' => trans('period::periods.validation.cod.min'),

            'start_date.required' => trans('period::periods.validation.start_date.required'),
            'start_date.array' => trans('period::periods.validation.start_date.array'),
            'start_date.not_contain_null' => trans('period::periods.validation.start_date.not_contain_null'),

            'end_date.required' => trans('period::periods.validation.end_date.required'),
            'end_date.array' => trans('period::periods.validation.end_date.array'),
            'end_date.not_contain_null' => trans('period::periods.validation.end_date.not_contain_null'),

            'date_range.date_in_order' => trans('period::periods.validation.date_range.date_in_order'),
            'date_range.date_not_conflict' => trans('period::periods.validation.date_range.date_not_conflict'),

            'date_range.date_not_conflict_other' => trans('period::periods.validation.date_range.date_not_conflict_other'),
        ];
    }
}
