<?php

namespace Modules\Service\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ImportServiceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'import_file' => 'required|mimes:xls,xlsx',
            'hotel_id' => 'required|array',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'import_file.required' => trans('service::services.validation.import_file.required'),
            'import_file.mimes' => trans('service::services.validation.import_file.mimes'),

            'hotel_id.required' => trans('service::services.validation.hotel_id.required'),
            'hotel_id.array' => trans('service::services.validation.hotel_id.array'),
        ];
    }
}
