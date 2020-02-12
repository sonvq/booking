<?php

return [
    'list resource' => 'Danh sách emails',
    'create resource' => 'Tạo emails',
    'edit resource' => 'Sửa emails',
    'destroy resource' => 'Xóa emails',
    'title' => [
        'emails' => 'Email',
        'create email' => 'Tạo một email',
        'edit email' => 'Sửa một email',
    ],
    'button' => [
        'create email' => 'Tạo một email',
    ],
    'table' => [
        'id' => 'ID',
        'type' => 'Mẫu email',
        'subject' => 'Tiêu đề',
        'content' => 'Nội dung',
        'status' => 'Trạng thái',
        'updated at' => 'Ngày sửa',
        'type_choices' => [
            'empty_option' => 'Chọn loại mẫu',
            'booking' => 'Booking'
        ],
        'status_choices' => [
            'empty_option' => 'Chọn trạng thái',
            'draft' => 'Nháp',
            'publish' => 'Xuất bản'
        ],
    ],

    'form' => [
    ],
    'messages' => [
    ],
    'validation' => [
        'subject' => [
            'required' => 'Trường tiêu đề không được bỏ trống.',
            'max' => 'Trường tiêu đề không được lớn hơn 255 ký tự.'
        ],

        'content' => [
            'required' => 'Trường nội dung không được bỏ trống.',
        ],

        'type' => [
            'required' => 'Trường mẫu email không được bỏ trống.',
            'unique' => 'Chỉ được tạo 1 bản ghi xuất bản cho loại đã chọn'
        ],

        'status' => [
            'required' => 'Trường trạng thái không được bỏ trống.',
        ],

    ],
];
