<?php

namespace Modules\Hotel\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateHotelRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'telephone' => 'required|regex:/^(\+?)[0-9]{8,15}$/',
            'region_id' => 'required|exists:region__regions,id',
            'company_id' => 'required|exists:company__companies,id',

            'change_buy' => 'in:increase,decrease|required_with:amount_buy,type_buy|nullable',
            'type_buy' => 'in:number,percentage|required_with:amount_buy,change_buy|nullable',
            'amount_buy' => 'required_with:change_buy,type_buy|nullable',

            'change_sell' => 'in:increase,decrease|required_with:amount_sell,type_sell|nullable',
            'type_sell' => 'in:number,percentage|required_with:amount_sell,change_sell|nullable',
            'amount_sell' => 'required_with:change_sell,type_sell|nullable',
        ];

        if (!empty($validationData['type_buy']) && $validationData['type_buy'] === 'percentage') {
            $rules['amount_buy'] = 'required_with:change_buy,type_buy|numeric|between:0,100|nullable';
        }

        if (!empty($validationData['type_buy']) && $validationData['type_buy'] === 'number') {
            $rules['amount_buy'] = 'required_with:change_buy,type_buy|numeric|min:1|nullable';
        }

        if (!empty($validationData['type_sell']) && $validationData['type_sell'] === 'percentage') {
            $rules['amount_sell'] = 'required_with:change_sell,type_sell|numeric|between:0,100|nullable';
        }

        if (!empty($validationData['type_sell']) && $validationData['type_sell'] === 'number') {
            $rules['amount_sell'] = 'required_with:change_sell,type_sell|numeric|min:1|nullable';
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
            'name.required' => trans('hotel::hotels.validation.name.required'),
            'name.max' => trans('hotel::hotels.validation.name.max'),

            'email.required' => trans('hotel::hotels.validation.email.required'),
            'email.max' => trans('hotel::hotels.validation.email.max'),
            'email.email' => trans('hotel::hotels.validation.email.email'),

            'telephone.required' => trans('hotel::hotels.validation.telephone.required'),
            'telephone.regex' => trans('hotel::hotels.validation.telephone.regex'),

            'region_id.required' => trans('hotel::hotels.validation.region_id.required'),
            'region_id.exists' => trans('hotel::hotels.validation.region_id.exists'),

            'company_id.required' => trans('hotel::hotels.validation.company_id.required'),
            'company_id.exists' => trans('hotel::hotels.validation.company_id.exists'),

            'change_buy.in' => trans('hotel::hotels.validation.change_buy.in'),
            'change_buy.required_with' => trans('hotel::hotels.validation.change_buy.required_with'),

            'type_buy.required_with' => trans('hotel::hotels.validation.type_buy.required_with'),
            'type_buy.in' => trans('hotel::hotels.validation.type_buy.in'),

            'amount_buy.required_with' => trans('hotel::hotels.validation.amount_buy.required_with'),
            'amount_buy.numeric' => trans('hotel::hotels.validation.amount_buy.numeric'),
            'amount_buy.min' => trans('hotel::hotels.validation.amount_buy.min'),
            'amount_buy.between' => trans('hotel::hotels.validation.amount_buy.between'),

            'change_sell.in' => trans('hotel::hotels.validation.change_sell.in'),
            'change_sell.required_with' => trans('hotel::hotels.validation.change_sell.required_with'),

            'type_sell.required_with' => trans('hotel::hotels.validation.type_sell.required_with'),
            'type_sell.in' => trans('hotel::hotels.validation.type_sell.in'),

            'amount_sell.required_with' => trans('hotel::hotels.validation.amount_sell.required_with'),
            'amount_sell.numeric' => trans('hotel::hotels.validation.amount_sell.numeric'),
            'amount_sell.min' => trans('hotel::hotels.validation.amount_sell.min'),
            'amount_sell.between' => trans('hotel::hotels.validation.amount_sell.between'),
        ];
    }
}
