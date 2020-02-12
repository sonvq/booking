<?php

namespace Modules\Room\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRoomRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|numeric|min:1',
            'hotel_id' => 'required|array',

            'change' => 'in:increase,decrease|required_with:amount,type|nullable',
            'type' => 'in:number,percentage|required_with:amount,change|nullable',
            'amount' => 'required_with:change,type|nullable',
        ];

        if (!empty($validationData['type']) && $validationData['type'] === 'percentage') {
            $rules['amount'] = 'required_with:change,type|numeric|between:0,100|nullable';
        }

        if (!empty($validationData['type']) && $validationData['type'] === 'number') {
            $rules['amount'] = 'required_with:change,type|numeric|min:1|nullable';
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
            'name.required' => trans('room::rooms.validation.name.required'),
            'name.max' => trans('room::rooms.validation.name.max'),

            'price.required' => trans('room::rooms.validation.price.required'),
            'price.numeric' => trans('room::rooms.validation.price.numeric'),
            'price.min' => trans('room::rooms.validation.price.min'),

            'hotel_id.required' => trans('room::rooms.validation.hotel_id.required'),
            'hotel_id.array' => trans('room::rooms.validation.hotel_id.array'),

            'change.in' => trans('room::rooms.validation.change.in'),
            'change.required_with' => trans('room::rooms.validation.change.required_with'),

            'type.required_with' => trans('room::rooms.validation.type.required_with'),
            'type.in' => trans('room::rooms.validation.type.in'),

            'amount.required_with' => trans('room::rooms.validation.amount.required_with'),
            'amount.numeric' => trans('room::rooms.validation.amount.numeric'),
            'amount.min' => trans('room::rooms.validation.amount.min'),
            'amount.between' => trans('room::rooms.validation.amount.between'),
        ];
    }
}
