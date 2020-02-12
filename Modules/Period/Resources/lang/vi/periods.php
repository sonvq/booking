<?php

return [
    'list resource' => 'Danh sách giai đoạn',
    'create resource' => 'Tạo giai đoạn',
    'edit resource' => 'Sửa giai đoạn',
    'destroy resource' => 'Xóa giai đoạn',
    'title' => [
        'periods' => 'Giai đoạn',
        'create period' => 'Tạo một giai đoạn',
        'edit period' => 'Sửa một giai đoạn',
    ],
    'button' => [
        'create period' => 'Tạo một giai đoạn',
    ],
    'table' => [
        'name' => 'Tên',
        'cod' => 'Hạn phạt hủy COD',
    ],
    'form' => [
        'name' => 'Tên',
        'cod' => 'Hạn phạt hủy COD',
        'country_id' => 'Quốc gia',
        'country_id_empty_option' => 'Chọn quốc gia',
        'hotel_id' => 'Khách sạn',
        'hotel_id_empty_option' => 'Chọn khách sạn',
        'date_range' => 'Khoảng thời gian',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'confirm_delete_date_row' => 'Bạn có chắc là muốn xóa dòng này?',
        'campaign_id' => 'Chương trình',
        'campaign_id_empty_option' => 'Chọn chương trình',
    ],
    'messages' => [
    ],
    'validation' => [
        'hotel_id' => [
            'required' => 'Trường khách sạn không được bỏ trống',
            'array' => 'Trường khách sạn phải ở dạng mảng'
        ],

        'campaign_id' => [
            'required' => 'Trường chương trình không được bỏ trống',
            'array' => 'Trường chương trình phải ở dạng mảng'
        ],

        'country_id' => [
            'array' => 'Trường quốc gia phải ở dạng mảng'
        ],

        'name' => [
            'required' => 'Trường tên không được bỏ trống',
            'max' => 'Trường tên không được lớn hơn 100 ký tự',
        ],

        'cod' => [
            'required' => 'Trường hạn phạt hủy COD không được bỏ trống',
            'numeric' => 'Trường hạn phạt hủy COD không phải là một số',
            'min' => 'Trường hạn phạt hủy COD phải lớn hơn 0',
        ],

        'start_date' => [
            'required' => 'Trường ngày bắt đầu không được bỏ trống',
            'array' => 'Trường ngày bắt đầu phải ở dạng mảng',
            'not_contain_null' => 'Trường ngày bắt đầu không được bỏ trống'
        ],

        'end_date' => [
            'required' => 'Trường ngày kết thúc không được bỏ trống',
            'array' => 'Trường ngày kết thúc phải ở dạng mảng',
            'not_contain_null' => 'Trường ngày kết thúc không được bỏ trống'
        ],

        'date_range' => [
            'date_in_order' => 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc',
            'date_not_conflict' => 'Các khoảng thời gian không được trùng lặp lên nhau',
            'date_not_conflict_other' => 'Các khoảng thời gian không được trùng lặp lên nhau với các bản ghi đã tạo trước đó có cùng khách sạn hoặc quốc gia'
        ]
    ],
];
