<?php

return [
    'list resource' => 'Danh sách NCC',
    'create resource' => 'Tạo NCC',
    'edit resource' => 'Sửa NCC',
    'destroy resource' => 'Xóa NCC',
    'title' => [
        'suppliers' => 'NCC',
        'create supplier' => 'Tạo một NCC',
        'edit supplier' => 'Sửa một NCC',
    ],
    'button' => [
        'create supplier' => 'Tạo một NCC',
    ],
    'table' => [
        'name' => 'Tên',
        'email' => 'E-mail',
        'telephone' => 'Số điện thoại',
        'description' => 'Mô tả',
        'amount' => 'Tăng thêm / Chiết khấu',
        'change' => 'Tăng / Giảm',
        'type' => 'Số tiền / Tỷ lệ %',
        'change_value' => [
            'increase' => 'Tăng',
            'decrease' => 'Giảm'
        ]
    ],
    'form' => [
        'name' => 'Tên',
        'email' => 'E-mail',
        'telephone' => 'Số điện thoại',
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
        ]
    ],
    'messages' => [
    ],
    'validation' => [
        'name' => [
            'required' => 'Trường tên không được bỏ trống',
            'max' => 'Trường tên không được lớn hơn 100 ký tự'
        ],
        'email' => [
            'email' => 'Trường E-mail phải là một địa chỉ email hợp lệ',
            'max' => 'Trường E-mail không được lớn hơn 255 ký tự'
        ],
        'telephone' => [
            'regex' => 'Trường số điện thoại có định dạng không hợp lệ',
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
