<?php

namespace Modules\Campaign\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCampaignRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
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
            'name.required' => trans('campaign::campaigns.validation.name.required'),
            'name.max' => trans('campaign::campaigns.validation.name.max'),

            'change.required' => trans('campaign::campaigns.validation.change.required'),
            'change.in' => trans('campaign::campaigns.validation.change.in'),

            'type.required' => trans('campaign::campaigns.validation.type.required'),
            'type.in' => trans('campaign::campaigns.validation.type.in'),

            'amount.required' => trans('campaign::campaigns.validation.amount.required'),
            'amount.numeric' => trans('campaign::campaigns.validation.amount.numeric'),
            'amount.min' => trans('campaign::campaigns.validation.amount.min'),
            'amount.between' => trans('campaign::campaigns.validation.amount.between'),
        ];
    }
}
