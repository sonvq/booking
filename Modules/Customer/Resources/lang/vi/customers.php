<?php

return [
    'list resource' => 'Danh sách khách hàng',
    'create resource' => 'Tạo khách hàng',
    'edit resource' => 'Sửa khách hàng',
    'destroy resource' => 'Xóa khách hàng',
    'title' => [
        'customers' => 'Khách hàng',
        'create customer' => 'Tạo mới một khách hàng',
        'edit customer' => 'Sửa một khách hàng',
    ],
    'button' => [
        'create customer' => 'Tạo mới một khách hàng',
    ],
    'tabs' => [
        'edit' => 'Sửa khách hàng',
        'booking' => 'Danh sách booking'
    ],
    'table' => [
        'name' => 'Họ và tên',
        'email' => 'Địa chỉ email',
        'telephone' => 'Số điện thoại',
        'identity' => 'Chứng minh thư',
        'birthday' => 'Ngày sinh',
        'country' => 'Quốc gia',
        'country_id' => 'Quốc gia',
        'appointment' => 'Ngày hẹn',
        'note' => 'Note',
        'gender' => 'Giới tính',
        'author_id' => 'Người tạo',
        'start_date' => 'Ngày bắt đầu',
        'date_empty_option_filter' => 'Chọn 1 loại ngày để filter',
        'end_date' => 'Ngày kết thúc',
        'reset_filter' => 'Đặt lại'
    ],
    'form' => [
        'appointment' => 'Ngày hẹn',
        'note' => 'Note',
        'gender' => 'Giới tính',
        'name' => 'Họ và tên',
        'email' => 'Địa chỉ email',
        'telephone' => 'Số điện thoại',
        'identity' => 'Chứng minh thư',
        'birthday' => 'Ngày sinh',
        'country' => 'Quốc gia',
        'country_id_empty_option' => 'Chọn quốc gia',
        'country_id' => 'Quốc gia',
        'gender_option' => [
            'female' => 'Nữ',
            'male' => 'Nam'
        ]
    ],
    'messages' => [
    ],
    'validation' => [
        'name' => [
            'required' => 'Trường họ và tên không được bỏ trống',
            'max' => 'Trường họ và tên không được lớn hơn 100 ký tự'
        ],
        'email' => [
            'required' => 'Trường địa chỉ email không được bỏ trống',
            'email' => 'Trường địa chỉ email phải là một địa chỉ email hợp lệ',
            'max' => 'Trường địa chỉ email không được lớn hơn 255 ký tự',
            'unique' => 'Trường địa chỉ email đã có trong cơ sở dữ liệu'
        ],
        'country_id' => [
            'required' => 'Trường quốc gia không được bỏ trống',
            'exists' => 'Giá trị đã chọn trong trường quốc gia không hợp lệ'
        ],
        'identity' => [
            'regex' => 'Trường chứng minh thư có định dạng không hợp lệ'
        ],
        'telephone' => [
            'regex' => 'Trường số điện thoại có định dạng không hợp lệ'
        ],

        'birthday' => [
            'date_format' => 'Trường ngày sinh không giống với định dạng ngày/tháng/năm',
        ]
    ],
];
