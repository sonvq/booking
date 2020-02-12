<?php

namespace Modules\Customer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCustomerRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'email|nullable|max:255|unique:customer__customers,email',
            'country_id' => 'required|exists:country__countries,id',
            'identity' => [
                'regex:/^([a-zA-Z]?)[0-9]{8,12}$/',
                'nullable',
            ],
            'telephone' => [
                'regex:/^(\+?)[0-9]{8,15}$/',
                'nullable',
            ],
            'birthday' => 'date_format:d/m/Y|nullable',
            'gender' => 'required|in:0,1',
            'appointment' => 'date_format:d/m/Y|nullable',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('customer::customers.validation.name.required'),
            'name.max' => trans('customer::customers.validation.name.max'),

            'email.required' => trans('customer::customers.validation.email.required'),
            'email.email' => trans('customer::customers.validation.email.email'),
            'email.max' => trans('customer::customers.validation.email.max'),
            'email.unique' => trans('customer::customers.validation.email.unique'),

            'country_id.required' => trans('customer::customers.validation.country_id.required'),
            'country_id.exists' => trans('customer::customers.validation.country_id.exists'),

            'identity.regex' => trans('customer::customers.validation.identity.regex'),

            'telephone.regex' => trans('customer::customers.validation.telephone.regex'),

            'birthday.date_format' => trans('customer::customers.validation.birthday.date_format'),
        ];
    }
}
