<?php

namespace Modules\Audit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAuditRequest extends BaseFormRequest
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
