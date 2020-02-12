<?php

namespace Modules\Audit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateAuditRequest extends BaseFormRequest
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
