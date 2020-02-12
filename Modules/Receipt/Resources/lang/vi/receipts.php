<?php

return [
    'list resource' => 'Danh sách phiếu thu',
    'create resource' => 'Tạo phiếu thu',
    'edit resource' => 'Sửa phiếu thu',
    'destroy resource' => 'Xóa phiếu thu',
    'title' => [
        'receipts' => 'Phiếu thu',
        'create receipt' => 'Tạo một phiếu thu',
        'edit receipt' => 'Sửa một phiếu thu',
        'export' => 'Export phiếu thu',
    ],
    'button' => [
        'create receipt' => 'Tạo một phiếu thu',
    ],
    'tabs' => [

    ],
    'table' => [
        'unique_number' => 'Mã phiếu thu',
        'booking_number' => 'Booking No.',
        'type' => 'Loại phiếu thu',
        'amount' => 'Số tiền',
        'payment_type' => 'Loại tiền',
        'status' => 'Trạng thái',
        'start_date' => 'Ngày nhận tiền',
        'author_id' => 'Người tạo',
        'reset_filter' => 'Đặt lại',
        'start_date_filter' => 'Ngày bắt đầu',
        'end_date_filter' => 'Ngày kết thúc',
        'submit_export' => 'Export',
    ],
    'form' => [
        'start_date' => 'Ngày nhận tiền',
        'amount' => 'Số tiền',
        'booking_id' => 'Booking No.',
        'note' => 'Note',
        'type_choices' => [
            'empty_type_option' => 'Chọn loại phiếu thu',
            'booking_payment' => 'Thanh toán booking',
            'salary' => 'Tiền lương',
            'tax' => 'Tiền thuế',
            'marketing_expense' => 'Chi phí marketing',
            'office_expense' => 'Chi phí văn phòng',
            'other_expense' => 'Chi phí khác'
        ],
        'type' => 'Loại phiếu thu',
        'payment_type' => 'Loại tiền',
        'payment_type_choices' => [
            'empty_payment_type_option' => 'Chọn loại tiền',
            'cash' => 'Tiền mặt',
            'bank_transfer' => 'Chuyển khoản',
            'deduct' => 'Khấu trừ',
        ],
        'empty_select_original_receipt' => 'Chọn phiếu thu nguồn',
        'parent_id' => 'Phiếu thu nguồn',
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
            'required' => 'Trường loại phiếu thu không được bỏ trống',
            'in' => 'Giá trị đã chọn trong trường loại phiếu thu không hợp lệ.',
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
            'exists' => 'Giá trị đã chọn trong trường phiếu thu nguồn không hợp lệ',
            'required_if' => 'Trường phiếu thu nguồn là bắt buộc khi loại tiền là khấu trừ',
            'invalid_deduct_amount' => 'Không thể khấu trừ từ phiếu thu này'
        ],
        'status' => [
            'required' => 'Trường trạng thái không được bỏ trống',
            'in' => 'Chỉ tài khoản kế toán mới có quyền thay đổi trạng thái của phiếu thu thành đã xác nhận'
        ],
        'start_date' => [
            'required' => 'Trường ngày nhận tiền không được bỏ trống',
            'date_format' => 'Trường ngày nhận tiền không giống với định dạng ngày/tháng/năm',
        ]
    ],
];
