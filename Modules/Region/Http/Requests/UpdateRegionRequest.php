<?php

namespace Modules\Region\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateRegionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('region::regions.validation.name.required')
        ];
    }
}
