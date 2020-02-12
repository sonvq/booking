<?php

return [
    'list resource' => 'Danh sách phòng',
    'create resource' => 'Tạo phòng',
    'edit resource' => 'Sửa phòng',
    'destroy resource' => 'Xóa phòng',
    'import resource' => 'Nhập phòng từ tập tin',
    'title' => [
        'rooms' => 'Phòng',
        'create room' => 'Tạo một phòng',
        'edit room' => 'Sửa một phòng',
        'import room' => 'Nhập phòng từ tập tin',
        'import hint text' => 'Hãy chọn tập tin để nhập phòng, chú ý hệ thống chỉ chấp nhận tập tin dạng excel'
    ],
    'button' => [
        'create room' => 'Tạo một phòng',
        'import room' => 'Nhập phòng từ tập tin',
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
        'import-room-successfully' => 'phòng đã được nhập từ tập tin thành công'
    ],
    'validation' => [
        'name' => [
            'required' => 'Trường tên không được bỏ trống',
            'max' => 'Trường tên không được lớn hơn 100 ký tự',
        ],

        'price' => [
            'required' => 'Trường giá không được bỏ trống',
            'numeric' => 'Trường giá không phải là một số',
            'min' => 'Trường giá phải lớn hơn 0',
        ],

        'hotel_id' => [
            'required' => 'Trường khách sạn không được bỏ trống',
            'array' => 'Trường khách sạn phải ở dạng mảng',
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
