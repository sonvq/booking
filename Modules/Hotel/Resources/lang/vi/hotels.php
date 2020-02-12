<?php

return [
    'list resource' => 'Danh sách khách sạn',
    'create resource' => 'Tạo mới khách sạn',
    'edit resource' => 'Sửa khách sạn',
    'destroy resource' => 'Xóa khách sạn',
    'title' => [
        'hotels' => 'Khách sạn',
        'create hotel' => 'Tạo mới một khách sạn',
        'edit hotel' => 'Sửa một khách sạn',
    ],
    'button' => [
        'create hotel' => 'Tạo mới một khách sạn',
    ],
    'table' => [
        'name' => 'Tên',
        'description' => 'Mô tả',
        'email' => 'Địa chỉ email',
        'telephone' => 'Số điện thoại',
        'region_id' => 'Khu vực',
        'company_id' => 'Công ty'
    ],
    'tabs' => [
        'hotel' => 'Sửa khách sạn',
        'room' => 'Danh sách phòng'
    ],
    'form' => [
        'name' => 'Tên',
        'description' => 'Mô tả',
        'email' => 'Địa chỉ email',
        'telephone' => 'Số điện thoại',
        'region_id' => 'Khu vực',
        'company_id' => 'Công ty',
        'company_id_empty_option' => 'Chọn công ty',
        'region_id_empty_option' => 'Chọn khu vực',

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
        'email' => [
            'required' => 'Trường địa chỉ email không được bỏ trống',
            'email' => 'Trường địa chỉ email phải là một địa chỉ email hợp lệ',
            'max' => 'Trường địa chỉ email không được lớn hơn 255 ký tự'
        ],
        'telephone' => [
            'regex' => 'Trường số điện thoại có định dạng không hợp lệ',
            'required' => 'Trường số điện thoại không được bỏ trống',
        ],
        'region_id' => [
            'exists' => 'Giá trị đã chọn trong trường khu vực không hợp lệ',
            'required' => 'Trường khu vực không được bỏ trống',
        ],
        'company_id' => [
            'exists' => 'Giá trị đã chọn trong trường công ty không hợp lệ',
            'required' => 'Trường công ty không được bỏ trống',
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
