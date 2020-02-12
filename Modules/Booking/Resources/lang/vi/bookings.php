<?php

return [
    'list resource' => 'Danh sách bookings',
    'create resource' => 'Tạo bookings',
    'edit resource' => 'Sửa bookings',
    'destroy resource' => 'Xóa bookings',
    'report resource' => 'Booking report',
    'financial resource' => 'Financial report',
    'export resource' => 'Booking export',
    'email resource' => 'Sending email',
    'email' => [
        'title' => [
            'date' => 'Ngày giờ',
            'from-to' => 'Người gửi - Người nhận',
            'from' => 'Người gửi',
            'to' => 'Người nhận',
            'subject' => 'Tiêu đề',
            'body' => 'Nội dung'
        ],
    ],
    'title' => [
        'email' => 'Gửi email',
        'bookings' => 'Booking',
        'export' => 'Export Booking',
        'create booking' => 'Tạo một booking',
        'edit booking' => 'Sửa một booking',
        'report booking' => 'Booking report',
        'financial booking' => 'Financial report',
        'financial-report' => [
            'booking' => 'Booking',
            'other' => 'Khác',
            'salary' => 'Tiền lương',
            'tax' => 'Tiền thuế',
            'marketing_expense' => 'Chi phí marketing',
            'office_expense' => 'Chi phí văn phòng',
            'other_expense' => 'Chi phí khác',
            'total_profit' => 'Tổng lợi nhuận'
        ]
    ],
    'button' => [
        'create booking' => 'Tạo một booking',
        'send' => 'Gửi email'
    ],
    'tabs' => [
        'booking' => 'Booking',
        'receipt' => 'Phiếu thu',
        'bill' => 'Phiếu chi',
        'send-email' => 'Gửi email',
        'list-email' => 'Danh sách email',
        'detail' => 'Chi tiết đặt phòng'
    ],
    'table' => [
        'supplier_id' => 'NCC',
        'agency_id-supplier_id' => 'Kênh - Đại lý / NCC',
        'total' => 'Tổng',
        'expense' => 'Chi phí',
        'customer_id' => 'Khách hàng',
        'booking_number' => 'Booking No.',
        'booking_status' => 'Tình trạng booking',
        'payment_status' => 'Tình trạng thanh toán của khách',
        'vendor_purchase_status' => 'Tình trạng thanh toán với khách sạn',
        'campaign_id' => 'Chương trình',
        'hotel_id' => 'Khách sạn',
        'agency_id' => 'Kênh / Đại lí',
        'status' => 'Tình trạng',
        'hotel_confirm_code' => 'Mã xác nhận',
        'flight_code' => 'Mã chuyến bay',
        'checkin-checkout' => 'Checkin / Checkout',
        'cod' => 'Hạn phạt hủy',
        'hotel_confirm_code-flight_code' => 'Mã xác nhận / Chuyến bay',
        'campaign_id-hotel_id' => 'Chương trình / Khách sạn',
        'sale_id-author_id' => 'Người xử lý / Sale',
        'sale_id' => 'Sale',
        'author_id' => 'Người xử lý',
        'checkin' => 'Checkin',
        'checkout' => 'Checkout',
        'date_empty_option_filter' => 'Chọn 1 loại ngày để filter',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'reset_filter' => 'Đặt lại',
        'booking_status_empty_option' => 'Chọn tình trạng booking',
        'payment_status_empty_option' => 'Chọn tình trạng thanh toán của khách',
        'vendor_purchase_status_empty_option' => 'Chọn tình trạng thanh toán với khách sạn',
        'booking_type_empty_option' => 'Chọn loại booking',
        'booking_type_urgent' => 'Booking gấp',
        'booking_type_in_due' => 'Booking sắp đến hạn',
        'booking_type_completed' => 'Booking đã hoàn thành',
        'booking_type_cancelled' => 'Booking đã hủy',
        'booking_type_in_dept' => 'Booking khách nợ tiền',
        'booking_type_customer_balance' => 'Khách dư tiền',
        'booking_type_hotel_balance' => 'Thanh toán KS dư',
        'total_amount' => 'Doanh thu',
        'total_profit' => 'Lợi nhuận',
        'total_night' => 'Room night',
        'submit_export' => 'Export',
    ],
    'form' => [
        'financial_report_choices' => [
            'total_sell_price' => 'Tổng doanh thu',
            'total_buy_price' => 'Tổng chi phí',
            'total_profit' => 'Tổng lợi nhuận',
            'total_customer_deposit' => 'Tổng tiền khách ứng trước',
            'total_customer_in_debt' => 'Dự thu',
            'total_hotel_in_debt' => 'Dự chi',
            'total_customer_deduct' => 'Tổng khấu trừ khách',
            'total_hotel_deduct' => 'Tổng khấu trừ khách sạn',
        ],
        'empty_report_type' => 'Chọn phân loại',
        'report_type'=> 'Phân loại',

        'empty_financial_type' => 'Chọn loại báo cáo',
        'financial_type'=> 'Phân loại',

        'yes_value' => 'Có',
        'no_value' => 'Không',

        'booking_status_choices' => [
            'created' => 'Khách đặt phòng',
            'hotel_sent' => 'Đã gửi cho khách sạn',
            'hotel_confirmed' => 'Khách sạn đã xác nhận',
            'hotel_rejected' => 'Khách sạn từ chối',
            'customer_rejected' => 'Khách hủy',
            'penalty_for_cancellation' => 'Phạt hủy'
        ],

        'payment_status_choices' => [
            'pending' => 'Chưa thanh toán',
            'payment_confirmation' => 'Xác nhận thanh toán',
            'partially_paid' => 'Thanh toán 1 phần',
            'fully_paid' => 'Đã thanh toán'
        ],

        'vendor_purchase_status_choices' => [
            'pending' => 'Chưa thanh toán',
            'completed' => 'Đã thanh toán',
            'partially_paid' => 'Thanh toán 1 phần'
        ],

        'cod' => 'Hạn phạt hủy',
        'booking_number' => 'Booking No.',

        'author_id' => 'Người xử lý',

        'hotel_id' => 'Khách sạn',
        'hotel_id_empty_option' => 'Chọn khách sạn',

        'agency_id' => 'Kênh / Đại lí',
        'agency_id_empty_option' => 'Chọn Kênh / Đại lí',

        'sale_id' => 'Sale',
        'sale_id_empty_option' => 'Chọn Sale',

        'customer_id' => 'Khách hàng',
        'customer_id_empty_option' => 'Chọn Khách hàng',

        'checkin_date' => 'Check in',
        'checkout_date' => 'Check out',

        'hotel_confirm_code' => 'Mã xác nhận',
        'flight_code' => 'Mã chuyến bay',

        'campaign_id' => 'Chương trình',
        'campaign_id_empty_option' => 'Chọn chương trình',

        'is_adjust_surcharge' => 'Điều chỉnh dịch vụ, phụ thu',
        'is_adjust_price' => 'Cho phép sửa giá',

        'room_id' => 'Loại phòng',
        'room_id_empty_option' => 'Chọn loại phòng',
        'room' => 'Phòng',
        'quantity' => 'SLượng',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'buy_price' => 'Giá nhập',
        'sell_price' => 'Giá bán',

        'confirm_delete_row' => 'Bạn có chắc là muốn xóa dòng này?',

        'service' => 'Dịch vụ',
        'service_id' => 'Loại dịch vụ',
        'service_quantity' => 'SLượng',
        'service_start_date' => 'Ngày bắt đầu',
        'service_end_date' => 'Ngày kết thúc',
        'service_buy_price' => 'Giá nhập',
        'service_sell_price' => 'Giá bán',
        'service_id_empty_option' => 'Chọn loại dịch vụ',

        'surcharge' => 'Phụ thu',
        'surcharge_id' => 'Loại phụ thu',
        'surcharge_quantity' => 'SLượng',
        'surcharge_start_date' => 'Ngày bắt đầu',
        'surcharge_end_date' => 'Ngày kết thúc',
        'surcharge_buy_price' => 'Giá nhập',
        'surcharge_sell_price' => 'Giá bán',
        'surcharge_id_empty_option' => 'Chọn loại phụ thu',

        'supplier_id_empty_option' => 'Chọn NCC',
        'supplier_id' => 'NCC',

        'total' => 'Tổng tiền',
        'total_price' => 'Doanh số',
        'total_buy_price' => 'Tổng nhập',
        'total_sell_price' => 'Tổng bán',
        'total_profit' => 'Lợi nhuận',

        'note' => 'Note',

        'booking_status' => 'Tình trạng booking',
        'payment_status' => 'Tình trạng thanh toán của khách',
        'vendor_purchase_status' => 'Tình trạng thanh toán với khách sạn',
    ],
    'messages' => [
        'change_booking_status_success_message' => 'Thay đổi tình trạng booking thành công',
        'change_payment_status_success_message' => 'Thay đổi tình trạng thanh toán của khách thành công',
        'change_vendor_purchase_status_success_message' => 'Thay đổi tình trạng thanh toán với khách sạn thành công',
        'success_title' => 'Thành công',
        'no_record_for_report' => 'Không có bản ghi nào cho booking report',
        'no_record_for_financial' => 'Không có bản ghi nào cho financial report',
        'no_email_template_available' => 'Không có bản ghi email template nào được tạo',
        'email sent successfully' => 'Gửi email thành công',
        'email sent fail' => 'Không thể gửi email, vui lòng liên hệ quản trị viên',
        'email sent fail because of booking status' => 'Booking quá hạn phạt hủy chỉ có thể gửi được email nếu trạng thái khách thanh toán là đã thanh toán',
        'no_email_related_this_booking' => 'Không có email nào gắn với booking này'
    ],
    'validation' => [
        'hotel_id' => [
            'required' => 'Trường khách sạn không được bỏ trống',
            'exists' => 'Giá trị đã chọn trong trường khách sạn không hợp lệ',
        ],
        'agency_id' => [
            'required' => 'Trường kênh / đại lí không được bỏ trống',
            'exists' => 'Giá trị đã chọn trong trường kênh / đại lí không hợp lệ',
        ],

        'sale_id' => [
            'exists' => 'Giá trị đã chọn trong trường sale không hợp lệ',
        ],

        'customer_id' => [
            'required' => 'Trường khách hàng không được bỏ trống',
            'exists' => 'Giá trị đã chọn trong trường khách hàng không hợp lệ',
        ],

        'checkin_date' => [
            'required' => 'Trường check in không được bỏ trống',
            'date_format' => 'Trường check in không giống với định dạng ngày/tháng/năm',
            'before' => 'Trường check in phải là một ngày trước ngày kết thúc',
        ],

        'date_range' => [
            'booking_date_in_range' => 'Vẫn còn ngày trống chưa được đặt phòng trong khoảng check in và check out'
        ],

        'checkout_date' => [
            'required' => 'Trường check out không được bỏ trống',
            'date_format' => 'Trường check out không giống với định dạng ngày/tháng/năm',
        ],

        'report_type' => [
            'required' => 'Trường phân loại không được bỏ trống',
        ],

        'financial_type' => [
            'required' => 'Trường phân loại không được bỏ trống',
        ],

        'hotel_confirm_code' => [
            'max' => 'Trường mã xác nhận không được lớn hơn 12 ký tự',
        ],

        'flight_code' => [
            'max' => 'Trường mã chuyến bay không được lớn hơn 24 ký tự',
        ],

        'campaign_id' => [
            'required' => 'Trường chương trình không được bỏ trống',
            'exists' => 'Giá trị đã chọn trong trường chương trình không hợp lệ',
        ],

        'room_id' => [
            'exists' => 'Giá trị đã chọn trong trường loại phòng không hợp lệ',
            'required' => 'Trường loại phòng không được bỏ trống',
        ],

        'service_id' => [
            'exists' => 'Giá trị đã chọn trong trường loại dịch vụ không hợp lệ',
            'required' => 'Trường loại dịch vụ không được bỏ trống',
        ],

        'surcharge_id' => [
            'exists' => 'Giá trị đã chọn trong trường loại phụ thu không hợp lệ',
            'required' => 'Trường loại phụ thu không được bỏ trống',
        ],

        'quantity' => [
            'numeric' => 'Trường số lượng không phải là một số',
            'min' => 'Trường số lượng phải lớn hơn 0',
            'required' => 'Trường số lượng không được bỏ trống',
        ],

        'start_date' => [
            'required' => 'Trường ngày bắt đầu không được bỏ trống',
            'date_format' => 'Trường ngày bắt đầu không giống với định dạng ngày/tháng/năm',
            'before' => 'Trường ngày bắt đầu phải là một ngày trước ngày kết thúc',
            'after_or_equal' => 'Trường ngày bắt đầu phải là thời gian bắt đầu sau hoặc đúng bằng check in date.',
        ],

        'end_date' => [
            'required' => 'Trường ngày kết thúc không được bỏ trống',
            'date_format' => 'Trường ngày kết thúc không giống với định dạng ngày/tháng/năm',
            'before_or_equal' => 'Trường ngày kết thúc phải là thời gian bắt đầu trước hoặc đúng bằng check out date.',
        ],

        'sell_price' => [
            'numeric' => 'Trường giá bán không phải là một số',
            'min' => 'Trường giá bán phải lớn hơn 0',
            'required' => 'Trường giá bán không được bỏ trống',
        ],

        'buy_price' => [
            'numeric' => 'Trường giá nhập không phải là một số',
            'min' => 'Trường giá nhập phải lớn hơn 0',
            'required' => 'Trường giá nhập không được bỏ trống',
        ],

        'total_price' => [
            'numeric' => 'Trường doanh số không phải là một số',
            'min' => 'Trường doanh số phải lớn hơn 0',
            'required' => 'Trường doanh số thiếu dữ liệu đầu vào để tính toán',
        ],

        'total_buy_price' => [
            'numeric' => 'Trường tổng nhập không phải là một số',
            'min' => 'Trường tổng nhập phải lớn hơn 0',
            'required' => 'Trường tổng nhập thiếu dữ liệu đầu vào để tính toán',
        ],

        'total_sell_price' => [
            'numeric' => 'Trường tổng bán không phải là một số',
            'min' => 'Trường tổng bán phải lớn hơn 0',
            'required' => 'Trường tổng bán thiếu dữ liệu đầu vào để tính toán',
        ],

        'total_profit' => [
            'numeric' => 'Trường lợi nhuận không phải là một số',
            'min' => 'Trường lợi nhuận phải lớn hơn 0',
            'required' => 'Trường lợi nhuận thiếu dữ liệu đầu vào để tính toán',
        ],
    ],
];
