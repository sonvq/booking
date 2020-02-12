<?php

return [
    'list resource' => 'Danh sách giá bán / khuyến mãi',
    'create resource' => 'Tạo giá bán / khuyến mãi',
    'edit resource' => 'Sửa giá bán / khuyến mãi',
    'destroy resource' => 'Xóa giá bán / khuyến mãi',
    'title' => [
        'promotions' => 'Giá bán / Khuyến mãi',
        'create promotion' => 'Tạo một giá bán / khuyến mãi',
        'edit promotion' => 'Sửa một giá bán / khuyến mãi',
    ],
    'button' => [
        'create promotion' => 'Tạo một giá bán / khuyến mãi',
    ],
    'table' => [
        'name' => 'Tên',
        'description' => 'Mô tả',
        'amount' => 'Tăng thêm / Chiết khấu',
        'change' => 'Tăng / Giảm',
        'type' => 'Số tiền / Tỷ lệ %',
        'change_value' => [
            'increase' => 'Tăng',
            'decrease' => 'Giảm'
        ],
    ],
    'form' => [
        'name' => 'Tên',
        'description' => 'Mô tả',
        'amount' => 'Tăng thêm / Chiết khấu',
        'change' => 'Tăng / Giảm',
        'type' => 'Số tiền / Tỷ lệ %',
        'change_value' => [
            'empty_option' => 'Chọn tăng / giảm',
            'increase' => 'Tăng',
            'decrease' => 'Giảm'
        ],
        'type_value' => [
            'empty_option' => 'Chọn số tiền / tỷ lệ %',
            'number' => 'Số tiền',
            'percentage' => 'Tỷ lệ %'
        ],
        'agency_id' => 'Kênh / Đại lí',
        'agency_id_empty_option' => 'Chọn kênh / đại lí',
        'campaign_id' => 'Chương trình',
        'campaign_id_empty_option' => 'Chọn chương trình',
        'hotel_id' => 'Khách sạn',
        'hotel_id_empty_option' => 'Chọn khách sạn',
        'room_id' => 'Loại phòng',
        'room_id_empty_option' => 'Chọn loại phòng'
    ],
    'messages' => [
    ],
    'validation' => [
        'name' => [
            'required' => 'Trường tên không được bỏ trống',
            'max' => 'Trường tên không được lớn hơn 100 ký tự'
        ],
        'change' => [
            'required' => 'Trường tăng / giảm không được bỏ trống',
            'in' => 'Giá trị đã chọn trong trường tăng / giảm không hợp lệ.',
        ],
        'type' => [
            'required' => 'Trường số tiền / tỷ lệ % không được bỏ trống',
            'in' => 'Giá trị đã chọn trong trường số tiền / tỷ lệ % không hợp lệ.',
        ],
        'amount' => [
            'required' => 'Trường tăng thêm / chiết khấu không được bỏ trống',
            'numeric' => 'Trường tăng thêm / chiết khấu phải là một số.',
            'min' => 'Khi chọn loại là số tiền, trường tăng thêm / chiết khấu phải lớn hơn 0',
            'between' => 'Khi chọn loại là tỷ lệ %, trường tăng thêm / chiết khấu phải nằm trong khoảng 0 - 100.'
        ],

        'hotel_id' => [
            'required' => 'Trường khách sạn không được bỏ trống',
            'array' => 'Trường khách sạn phải ở dạng mảng',
        ],

        'agency_id' => [
            'required' => 'Trường kênh / đại lý không được bỏ trống',
            'array' => 'Trường kênh / đại lý phải ở dạng mảng',
        ],

        'room_id' => [
            'required' => 'Trường loại phòng không được bỏ trống',
            'array' => 'Trường loại phòng phải ở dạng mảng',
        ],

        'campaign_id' => [
            'exists' => 'Giá trị đã chọn trong trường chương trình không hợp lệ',
            'required' => 'Trường chương trình không được bỏ trống',
        ],
    ],
];
