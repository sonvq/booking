<?php

namespace Modules\Surcharge\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ImportSurchargeRequest extends BaseFormRequest
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
            'import_file.required' => trans('surcharge::surcharges.validation.import_file.required'),
            'import_file.mimes' => trans('surcharge::surcharges.validation.import_file.mimes'),

            'hotel_id.required' => trans('surcharge::surcharges.validation.hotel_id.required'),
            'hotel_id.array' => trans('surcharge::surcharges.validation.hotel_id.array'),
        ];
    }
}
