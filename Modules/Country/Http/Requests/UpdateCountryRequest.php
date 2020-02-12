<?php

namespace Modules\Country\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCountryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }
}
