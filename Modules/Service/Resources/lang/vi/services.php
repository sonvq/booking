<?php

return [
    'list resource' => 'Danh sách dịch vụ',
    'create resource' => 'Tạo dịch vụ',
    'edit resource' => 'Sửa dịch vụ',
    'destroy resource' => 'Xóa dịch vụ',
    'import resource' => 'Nhập dịch vụ từ tập tin',
    'title' => [
        'services' => 'Dịch vụ',
        'create service' => 'Tạo một dịch vụ',
        'edit service' => 'Sửa một dịch vụ',
        'import service' => 'Nhập dịch vụ từ tập tin',
        'import hint text' => 'Hãy chọn tập tin để nhập dịch vụ, chú ý hệ thống chỉ chấp nhận tập tin dạng excel'
    ],
    'button' => [
        'create service' => 'Tạo một dịch vụ',
        'import service' => 'Nhập dịch vụ từ tập tin',
        'import' => 'Nhập'
    ],
    'table' => [
        'name' => 'Tên',
        'description' => 'Mô tả',
        'amount' => 'Tăng thêm / Chiết khấu',
        'change' => 'Tăng / Giảm',
        'type' => 'Số tiền / Tỷ lệ %',
        'price' => 'Giá',
        'hotel_id' => 'Khách sạn',
    ],
    'form' => [
        'import_file' => 'Tập tin nhập liệu',
        'name' => 'Tên',
        'hotel_id' => 'Khách sạn',
        'description' => 'Mô tả',
        'amount' => 'Tăng thêm / Chiết khấu',
        'price' => 'Giá',
        'change' => 'Tăng / Giảm',
        'type' => 'Số tiền / Tỷ lệ %',
        'change_value' => [
            'empty_option' => 'Chọn tăng / giảm',
            'increase' => 'Tăng',
            'decrease' => 'Giảm',
        ],
        'hotel_id_empty_option' => 'Chọn khách sạn',
        'type_value' => [
            'empty_option' => 'Chọn số tiền / tỷ lệ %',
            'number' => 'Số tiền',
            'percentage' => 'Tỷ lệ %',
        ],
    ],
    'messages' => [
        'import-service-successfully' => 'dịch vụ đã được nhập từ tập tin thành công'
    ],
    'validation' => [
        'name' => [
            'required' => 'Trường tên không được bỏ trống',
            'max' => 'Trường tên không được lớn hơn 100 ký tự',
        ],

        'price' => [
            'required' => 'Trường giá không được bỏ trống',
            'numeric' => 'Trường giá không phải là một số',
            'min' => 'Trường giá phải lớn hơn 0'
        ],

        'hotel_id' => [
            'required' => 'Trường khách sạn không được bỏ trống',
            'array' => 'Trường khách sạn phải ở dạng mảng'
        ],

        'change' => [
            'in' => 'Giá trị đã chọn trong trường tăng / giảm không hợp lệ.',
            'required_with' => 'Trường Tăng / Giảm không được bỏ trống khi một trong Tăng thêm / Chiết khấu hoặc Số tiền / Tỷ lệ % có giá trị.',
        ],
        'type' => [
            'in' => 'Giá trị đã chọn trong trường số tiền / tỷ lệ % không hợp lệ.',
            'required_with' => 'Trường Số tiền / Tỷ lệ % không được bỏ trống khi một trong Tăng thêm / Chiết khấu hoặc Tăng / Giảm có giá trị.',
        ],
        'amount' => [
            'numeric' => 'Trường tăng thêm / chiết khấu phải là một số.',
            'min' => 'Khi chọn loại là số tiền, trường tăng thêm / chiết khấu phải lớn hơn 0',
            'between' => 'Khi chọn loại là tỷ lệ %, trường tăng thêm / chiết khấu phải nằm trong khoảng 0 - 100.',
            'required_with' => 'Trường Tăng thêm / Chiết khấu không được bỏ trống khi một trong Tăng / Giảm hoặc Số tiền / Tỷ lệ % có giá trị.',
        ],

        'import_file' => [
            'required' => 'Trường tập tin nhập liệu không được bỏ trống',
            'mimes' => 'Trường tập tin nhập liệu không phải là một tập tin có định dạng: xls, xlsx'
        ]
    ],
];
