<?php

return [
    'list resource' => 'Danh sách phiếu chi',
    'create resource' => 'Tạo phiếu chi',
    'edit resource' => 'Sửa phiếu chi',
    'destroy resource' => 'Xóa phiếu chi',
    'title' => [
        'bills' => 'Phiếu chi',
        'create bill' => 'Tạo một phiếu chi',
        'edit bill' => 'Sửa một phiếu chi',
        'export' => 'Export phiếu chi',
    ],
    'button' => [
        'create bill' => 'Tạo một phiếu chi',
    ],
    'tabs' => [

    ],
    'table' => [
        'submit_export' => 'Export',
        'unique_number' => 'Mã phiếu chi',
        'booking_number' => 'Booking No.',
        'type' => 'Loại phiếu chi',
        'amount' => 'Số tiền',
        'payment_type' => 'Loại tiền',
        'status' => 'Trạng thái',
        'start_date' => 'Ngày xuất tiền',
        'author_id' => 'Người tạo',
        'reset_filter' => 'Đặt lại',
        'start_date_filter' => 'Ngày bắt đầu',
        'end_date_filter' => 'Ngày kết thúc'
    ],
    'form' => [
        'start_date' => 'Ngày xuất tiền',
        'amount' => 'Số tiền',
        'booking_id' => 'Booking No.',
        'note' => 'Note',
        'type_choices' => [
            'empty_type_option' => 'Chọn loại phiếu chi',
            'booking_payment' => 'Thanh toán booking',
            'salary' => 'Tiền lương',
            'tax' => 'Tiền thuế',
            'marketing_expense' => 'Chi phí marketing',
            'office_expense' => 'Chi phí văn phòng',
            'other_expense' => 'Chi phí khác'
        ],
        'type' => 'Loại phiếu chi',
        'payment_type' => 'Loại tiền',
        'payment_type_choices' => [
            'empty_payment_type_option' => 'Chọn loại tiền',
            'cash' => 'Tiền mặt',
            'bank_transfer' => 'Chuyển khoản',
            'deduct' => 'Khấu trừ',
        ],
        'empty_select_original_bill' => 'Chọn phiếu chi nguồn',
        'parent_id' => 'Phiếu chi nguồn',
        'status_choices' => [
            'empty_status_option' => 'Chọn trạng thái',
            'pending' => 'Chưa xác nhận',
            'confirmed' => 'Đã xác nhận'
        ],
        'status' => 'Trạng thái'
    ],
    'messages' => [

    ],
    'validation' => [
        'booking_id' => [
            'exists' => 'Giá trị đã chọn trong trường Booking No. không hợp lệ'
        ],
        'type' => [
            'required' => 'Trường loại phiếu chi không được bỏ trống',
            'in' => 'Giá trị đã chọn trong trường loại phiếu chi không hợp lệ.',
        ],
        'payment_type' => [
            'required' => 'Trường loại tiền không được bỏ trống',
            'in' => 'Giá trị đã chọn trong trường loại tiền không hợp lệ.',
        ],
        'amount' => [
            'required' => 'Trường số tiền không được bỏ trống',
            'numeric' => 'Trường số tiền không phải là một số',
            'min' => 'Trường số tiền phải lớn hơn 0',
            'max' => 'Trường số tiền vượt quá số tiền có thể khấu trừ'
        ],
        'parent_id' => [
            'exists' => 'Giá trị đã chọn trong trường phiếu chi nguồn không hợp lệ',
            'required_if' => 'Trường phiếu chi nguồn là bắt buộc khi loại tiền là khấu trừ',
            'invalid_deduct_amount' => 'Không thể khấu trừ từ phiếu chi này'
        ],
        'status' => [
            'required' => 'Trường trạng thái không được bỏ trống',
            'in' => 'Chỉ tài khoản kế toán mới có quyền thay đổi trạng thái của phiếu chi thành đã xác nhận'
        ],
        'start_date' => [
            'required' => 'Trường ngày xuất tiền không được bỏ trống',
            'date_format' => 'Trường ngày xuất tiền không giống với định dạng ngày/tháng/năm',
        ]
    ],
];
