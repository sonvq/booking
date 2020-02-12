<?php

return [
    'list resource' => 'Danh sách chương trình',
    'create resource' => 'Tạo chương trình',
    'edit resource' => 'Sửa chương trình',
    'destroy resource' => 'Xóa chương trình',
    'title' => [
        'campaigns' => 'Chương trình',
        'create campaign' => 'Tạo một chương trình',
        'edit campaign' => 'Sửa một chương trình',
    ],
    'button' => [
        'create campaign' => 'Tạo mới một chương trình',
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

        'hotel_id' => 'Khách sạn',
        'hotel_id_empty_option' => 'Chọn khách sạn',

        'room_id' => 'Loại phòng',
        'room_id_empty_option' => 'Chọn loại phòng',

        'service_id' => 'Dịch vụ',
        'service_id_empty_option' => 'Chọn dịch vụ',

        'surcharge_id' => 'Phụ thu',
        'surcharge_id_empty_option' => 'Chọn phụ thu'
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
    ],
];
