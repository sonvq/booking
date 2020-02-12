<?php

return [
    'list resource' => 'Danh sách công ty',
    'create resource' => 'Tạo công ty',
    'edit resource' => 'Sửa công ty',
    'destroy resource' => 'Xóa công ty',
    'title' => [
        'companies' => 'Công ty',
        'create company' => 'Tạo một công ty',
        'edit company' => 'Sửa một công ty',
    ],
    'button' => [
        'create company' => 'Tạo một công ty',
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
        'description' => 'Mô tả',

        'amount_buy' => 'Tăng thêm / Chiết khấu (Mua)',
        'change_buy' => 'Tăng / Giảm',
        'type_buy' => 'Số tiền / Tỷ lệ %',

        'amount_sell' => 'Tăng thêm / Chiết khấu (Bán)',
        'change_sell' => 'Tăng / Giảm',
        'type_sell' => 'Số tiền / Tỷ lệ %',

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
        'change_buy' => [
            'in' => 'Giá trị đã chọn trong trường tăng / giảm không hợp lệ.',
            'required_with' => 'Trường Tăng / Giảm không được bỏ trống khi một trong Tăng thêm / Chiết khấu (Mua) hoặc Số tiền / Tỷ lệ % có giá trị.'
        ],
        'type_buy' => [
            'in' => 'Giá trị đã chọn trong trường số tiền / tỷ lệ % không hợp lệ.',
            'required_with' => 'Trường Số tiền / Tỷ lệ % không được bỏ trống khi một trong Tăng thêm / Chiết khấu (Mua) hoặc Tăng / Giảm có giá trị.'
        ],
        'amount_buy' => [
            'numeric' => 'Trường tăng thêm / chiết khấu (Mua) phải là một số.',
            'min' => 'Khi chọn loại là số tiền, trường tăng thêm / chiết khấu (Mua) phải lớn hơn 0',
            'between' => 'Khi chọn loại là tỷ lệ %, trường tăng thêm / chiết khấu (Mua) phải nằm trong khoảng 0 - 100.',
            'required_with' => 'Trường Tăng thêm / Chiết khấu (Mua) không được bỏ trống khi một trong Tăng / Giảm hoặc Số tiền / Tỷ lệ % có giá trị.'
        ],

        'change_sell' => [
            'in' => 'Giá trị đã chọn trong trường tăng / giảm không hợp lệ.',
            'required_with' => 'Trường Tăng / Giảm không được bỏ trống khi một trong Tăng thêm / Chiết khấu (Bán) hoặc Số tiền / Tỷ lệ % có giá trị.'
        ],
        'type_sell' => [
            'in' => 'Giá trị đã chọn trong trường số tiền / tỷ lệ % không hợp lệ.',
            'required_with' => 'Trường Số tiền / Tỷ lệ % không được bỏ trống khi một trong Tăng thêm / Chiết khấu (Bán) hoặc Tăng / Giảm có giá trị.'
        ],
        'amount_sell' => [
            'numeric' => 'Trường tăng thêm / chiết khấu (Bán) phải là một số.',
            'min' => 'Khi chọn loại là số tiền, trường tăng thêm / chiết khấu (Bán) phải lớn hơn 0',
            'between' => 'Khi chọn loại là tỷ lệ %, trường tăng thêm / chiết khấu (Bán) phải nằm trong khoảng 0 - 100.',
            'required_with' => 'Trường Tăng thêm / Chiết khấu (Bán) không được bỏ trống khi một trong Tăng / Giảm hoặc Số tiền / Tỷ lệ % có giá trị.'
        ],
    ],
];
