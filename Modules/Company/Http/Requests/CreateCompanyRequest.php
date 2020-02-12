<?php

namespace Modules\Company\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCompanyRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',

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
            'name.required' => trans('company::companies.validation.name.required'),
            'name.max' => trans('company::companies.validation.name.max'),

            'change_buy.in' => trans('company::companies.validation.change_buy.in'),
            'change_buy.required_with' => trans('company::companies.validation.change_buy.required_with'),

            'type_buy.required_with' => trans('company::companies.validation.type_buy.required_with'),
            'type_buy.in' => trans('company::companies.validation.type_buy.in'),

            'amount_buy.required_with' => trans('company::companies.validation.amount_buy.required_with'),
            'amount_buy.numeric' => trans('company::companies.validation.amount_buy.numeric'),
            'amount_buy.min' => trans('company::companies.validation.amount_buy.min'),
            'amount_buy.between' => trans('company::companies.validation.amount_buy.between'),

            'change_sell.in' => trans('company::companies.validation.change_sell.in'),
            'change_sell.required_with' => trans('company::companies.validation.change_sell.required_with'),

            'type_sell.required_with' => trans('company::companies.validation.type_sell.required_with'),
            'type_sell.in' => trans('company::companies.validation.type_sell.in'),

            'amount_sell.required_with' => trans('company::companies.validation.amount_sell.required_with'),
            'amount_sell.numeric' => trans('company::companies.validation.amount_sell.numeric'),
            'amount_sell.min' => trans('company::companies.validation.amount_sell.min'),
            'amount_sell.between' => trans('company::companies.validation.amount_sell.between'),
        ];
    }
}
