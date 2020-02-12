<?php

namespace Modules\Room\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ImportRoomRequest extends BaseFormRequest
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
            'import_file.required' => trans('room::rooms.validation.import_file.required'),
            'import_file.mimes' => trans('room::rooms.validation.import_file.mimes'),

            'hotel_id.required' => trans('room::rooms.validation.hotel_id.required'),
            'hotel_id.array' => trans('room::rooms.validation.hotel_id.array'),
        ];
    }
}
