<?php

namespace Modules\Promotion\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePromotionRequest extends BaseFormRequest
{
    public function rules()
    {
        $validationData = $this->validationData();

        $rules = [
            'name' => 'required|max:100',
            'change' => 'required|in:increase,decrease',
            'type' => 'required|in:number,percentage',
            'amount' => 'required',

            'agency_id' => 'required|array',
            'campaign_id' => 'required|exists:campaign__campaigns,id',
            'hotel_id' => 'required|array',
            'room_id' => 'required|array',
        ];

        if (!empty($validationData['type']) && $validationData['type'] === 'percentage') {
            $rules['amount'] = 'required|numeric|between:0,100';
        }

        if (!empty($validationData['type']) && $validationData['type'] === 'number') {
            $rules['amount'] = 'required|numeric|min:1';
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
            'name.required' => trans('promotion::promotions.validation.name.required'),
            'name.max' => trans('promotion::promotions.validation.name.max'),

            'change.required' => trans('promotion::promotions.validation.change.required'),
            'change.in' => trans('promotion::promotions.validation.change.in'),

            'type.required' => trans('promotion::promotions.validation.type.required'),
            'type.in' => trans('promotion::promotions.validation.type.in'),

            'amount.required' => trans('promotion::promotions.validation.amount.required'),
            'amount.numeric' => trans('promotion::promotions.validation.amount.numeric'),
            'amount.min' => trans('promotion::promotions.validation.amount.min'),
            'amount.between' => trans('promotion::promotions.validation.amount.between'),

            'agency_id.required' => trans('promotion::promotions.validation.agency_id.required'),
            'agency_id.array' => trans('promotion::promotions.validation.agency_id.array'),

            'hotel_id.required' => trans('promotion::promotions.validation.hotel_id.required'),
            'hotel_id.array' => trans('promotion::promotions.validation.hotel_id.array'),

            'room_id.required' => trans('promotion::promotions.validation.room_id.required'),
            'room_id.array' => trans('promotion::promotions.validation.room_id.array'),

            'campaign_id.required' => trans('promotion::promotions.validation.campaign_id.required'),
            'campaign_id.exists' => trans('promotion::promotions.validation.campaign_id.exists'),
        ];
    }
}
