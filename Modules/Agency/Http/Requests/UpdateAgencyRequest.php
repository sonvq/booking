<?php

namespace Modules\Agency\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateAgencyRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
            'email' => 'email|max:255|nullable',
            'telephone' => [
                'regex:/^(\+?)[0-9]{8,15}$/',
                'nullable',
            ],
            'change' => 'required|in:increase,decrease',
            'type' => 'required|in:number,percentage',
            'amount' => 'required',
        ];

        if (!empty($validationData['type']) && $validationData['type'] === 'percentage') {
            $rules['amount'] = 'required|numeric|between:0,100';
        }

        if (!empty($validationData['type']) && $validationData['type'] === 'number') {
            $rules['amount'] = 'required|numeric|min:1';
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
            'name.required' => trans('agency::agencies.validation.name.required'),
            'name.max' => trans('agency::agencies.validation.name.max'),

            'email.max' => trans('agency::agencies.validation.email.max'),
            'email.email' => trans('agency::agencies.validation.email.email'),

            'telephone.regex' => trans('agency::agencies.validation.telephone.regex'),

            'change.required' => trans('agency::agencies.validation.change.required'),
            'change.in' => trans('agency::agencies.validation.change.in'),

            'type.required' => trans('agency::agencies.validation.type.required'),
            'type.in' => trans('agency::agencies.validation.type.in'),

            'amount.required' => trans('agency::agencies.validation.amount.required'),
            'amount.numeric' => trans('agency::agencies.validation.amount.numeric'),
            'amount.min' => trans('agency::agencies.validation.amount.min'),
            'amount.between' => trans('agency::agencies.validation.amount.between'),
        ];
    }
}
