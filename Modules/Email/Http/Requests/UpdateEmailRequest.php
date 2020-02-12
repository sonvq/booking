<?php

namespace Modules\Email\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Email\Entities\Email;

class UpdateEmailRequest extends BaseFormRequest
{
    public function rules()
    {
        $email = $this->route('email');
        $validationData = $this->validationData();
        $status = !empty($validationData['status']) ? $validationData['status'] : '';

        $rules = [
            'subject' => 'required|max:255',
            'content' => 'required',
            'status' => 'required',
            'type' => [
                'required'
            ],
        ];

        if ($status === Email::STATUS_PUBLISH) {
            $rules['type'] = [
                'required',
                Rule::unique('email__emails')->ignore($email->id)->where(function ($query) {
                    return $query->where('status', 'publish');
                })
            ];
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
            'subject.required' => trans('email::emails.validation.subject.required'),
            'subject.max' => trans('email::emails.validation.subject.max'),

            'content.required' => trans('email::emails.validation.content.required'),

            'type.required' => trans('email::emails.validation.type.required'),
            'type.unique' => trans('email::emails.validation.type.unique'),

            'status.required' => trans('email::emails.validation.status.required'),
        ];
    }

}
