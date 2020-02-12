<?php

namespace Modules\Supplier\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateSupplierRequest extends BaseFormRequest
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
            'name.required' => trans('supplier::suppliers.validation.name.required'),
            'name.max' => trans('supplier::suppliers.validation.name.max'),

            'email.max' => trans('supplier::suppliers.validation.email.max'),
            'email.email' => trans('supplier::suppliers.validation.email.email'),

            'telephone.regex' => trans('supplier::suppliers.validation.telephone.regex'),

            'change.required' => trans('supplier::suppliers.validation.change.required'),
            'change.in' => trans('supplier::suppliers.validation.change.in'),

            'type.required' => trans('supplier::suppliers.validation.type.required'),
            'type.in' => trans('supplier::suppliers.validation.type.in'),

            'amount.required' => trans('supplier::suppliers.validation.amount.required'),
            'amount.numeric' => trans('supplier::suppliers.validation.amount.numeric'),
            'amount.min' => trans('supplier::suppliers.validation.amount.min'),
            'amount.between' => trans('supplier::suppliers.validation.amount.between'),
        ];
    }
}