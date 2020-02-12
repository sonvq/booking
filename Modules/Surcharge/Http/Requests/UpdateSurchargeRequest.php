<?php

namespace Modules\Surcharge\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateSurchargeRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|numeric|min:1',
            'hotel_id' => 'required|array',

            'change' => 'in:increase,decrease|required_with:amount,type|nullable',
            'type' => 'in:number,percentage|required_with:amount,change|nullable',
            'amount' => 'required_with:change,type|nullable',
        ];

        if (!empty($validationData['type']) && $validationData['type'] === 'percentage') {
            $rules['amount'] = 'required_with:change,type|numeric|between:0,100|nullable';
        }

        if (!empty($validationData['type']) && $validationData['type'] === 'number') {
            $rules['amount'] = 'required_with:change,type|numeric|min:1|nullable';
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('surcharge::surcharges.validation.name.required'),
            'name.max' => trans('surcharge::surcharges.validation.name.max'),

            'price.required' => trans('surcharge::surcharges.validation.price.required'),
            'price.numeric' => trans('surcharge::surcharges.validation.price.numeric'),
            'price.min' => trans('surcharge::surcharges.validation.price.min'),

            'hotel_id.required' => trans('surcharge::surcharges.validation.hotel_id.required'),
            'hotel_id.array' => trans('surcharge::surcharges.validation.hotel_id.array'),

            'change.in' => trans('surcharge::surcharges.validation.change.in'),
            'change.required_with' => trans('surcharge::surcharges.validation.change.required_with'),

            'type.required_with' => trans('surcharge::surcharges.validation.type.required_with'),
            'type.in' => trans('surcharge::surcharges.validation.type.in'),

            'amount.required_with' => trans('surcharge::surcharges.validation.amount.required_with'),
            'amount.numeric' => trans('surcharge::surcharges.validation.amount.numeric'),
            'amount.min' => trans('surcharge::surcharges.validation.amount.min'),
            'amount.between' => trans('surcharge::surcharges.validation.amount.between'),
        ];
    }
}
