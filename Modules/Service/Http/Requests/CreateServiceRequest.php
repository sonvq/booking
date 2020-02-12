<?php

namespace Modules\Service\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateServiceRequest extends BaseFormRequest
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
            'name.required' => trans('service::services.validation.name.required'),
            'name.max' => trans('service::services.validation.name.max'),

            'price.required' => trans('service::services.validation.price.required'),
            'price.numeric' => trans('service::services.validation.price.numeric'),
            'price.min' => trans('service::services.validation.price.min'),

            'hotel_id.required' => trans('service::services.validation.hotel_id.required'),
            'hotel_id.array' => trans('service::services.validation.hotel_id.array'),

            'change.in' => trans('service::services.validation.change.in'),
            'change.required_with' => trans('service::services.validation.change.required_with'),

            'type.required_with' => trans('service::services.validation.type.required_with'),
            'type.in' => trans('service::services.validation.type.in'),

            'amount.required_with' => trans('service::services.validation.amount.required_with'),
            'amount.numeric' => trans('service::services.validation.amount.numeric'),
            'amount.min' => trans('service::services.validation.amount.min'),
            'amount.between' => trans('service::services.validation.amount.between'),
        ];
    }
}
