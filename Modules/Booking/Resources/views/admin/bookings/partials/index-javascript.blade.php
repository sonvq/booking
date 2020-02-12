@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.booking.booking.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        var table;

        function parseDate(str) {
            var dmy = str.split('/');
            return new Date(dmy[2], dmy[1]-1, dmy[0]);
        }
        function datediff(first, second) {
            return Math.round((second-first)/(1000*60*60*24));
        }

        $(function () {
            $('#reset_filter').on('click', function(){
                $('#table_filter_container input').each(function(){
                    $(this).val('');
                });
                $('#table_filter_container select').each(function(){
                    $(this).val('');
                });
                table.DataTable().draw();
            });

            table = $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });

            // Search for booking number
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#booking_number_filter').val();
                    var original = data[1];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for campaign name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#campaign_id_filter').val();
                    var original = data[21];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for hotel name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#hotel_id_filter').val();
                    var original = data[22];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for sale name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#sale_id_filter').val();
                    var original = data[23];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for author name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#author_id_filter').val();
                    var original = data[24];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );


            // Search for agency name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#agency_id_filter').val();
                    var original = data[25];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for supplier name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#supplier_id_filter').val();
                    var original = data[26];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for customer
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#customer_id_filter').val();
                    var original = data[4];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for date
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var dateTypeSelected = $('#date_filter').val();
                    var startDateInputted = $('#start_date_filter').val();
                    var endDateInputted = $('#end_date_filter').val();

                    if(dateTypeSelected === "") {
                        return true;
                    }
                    if (dateTypeSelected !== "" && startDateInputted === "" && endDateInputted === "") {
                        return true;
                    }
                    if (dateTypeSelected !== "")
                    {
                        var compareValue = "";
                        if (dateTypeSelected === 'checkin_date') {
                            compareValue = data[10];
                        } else if (dateTypeSelected === 'checkout_date') {
                            compareValue = data[11];
                        } else if (dateTypeSelected === 'cod') {
                            compareValue = data[8];
                        }

                        if(startDateInputted !== "" && endDateInputted !== "") {
                            if (parseDate(startDateInputted) <= parseDate(compareValue) && parseDate(compareValue) <= parseDate(endDateInputted)) {
                                return true;
                            }
                        } else if (startDateInputted !== "") {
                            if (parseDate(startDateInputted) <= parseDate(compareValue)) {
                                return true;
                            }
                        } else if (endDateInputted !== "") {
                            if (parseDate(compareValue) <= parseDate(endDateInputted)) {
                                return true;
                            }
                        }
                    }
                    return false;
                }
            );

            // Search for booking type
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var selected = $('#booking_type_filter').val();
                    var bookingStatus = data[12];
                    var paymentStatus = data[13];
                    var vendorPurchaseStatus = data[14];
                    var cod = data[8];
                    var codDate = parseDate(cod);
                    var today = new Date();
                    var totalSellPrice = data[17];
                    var totalBuyPrice = data[18];
                    var totalReceiptAmount = data[19];
                    var totalBillAmount = data[20];

                    // console.log("totalSellPrice = " + totalSellPrice);
                    // console.log("totalBuyPrice = " + totalBuyPrice);
                    // console.log("totalReceiptAmount = " + totalReceiptAmount);
                    // console.log("totalBillAmount = " + totalBillAmount);

                    if (selected === "") {
                        return true;
                    }

                    if (selected === "booking_urgent") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CREATED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_SENT }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (paymentStatus !== "{{ \Modules\Booking\Entities\Booking::PAYMENT_STATUS_FULLY_PAID }}"
                                || vendorPurchaseStatus !== "{{ \Modules\Booking\Entities\Booking::VENDOR_PURCHASE_STATUS_COMPLETED }}")
                            &&
                            (today >= codDate)
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_in_due") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CREATED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_SENT }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (paymentStatus !== "{{ \Modules\Booking\Entities\Booking::PAYMENT_STATUS_FULLY_PAID }}"
                                || vendorPurchaseStatus !== "{{ \Modules\Booking\Entities\Booking::VENDOR_PURCHASE_STATUS_COMPLETED }}")
                            &&
                            (datediff(today, codDate) > 0 && datediff(today, codDate) <= 7)
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_completed") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (paymentStatus === "{{ \Modules\Booking\Entities\Booking::PAYMENT_STATUS_FULLY_PAID }}")
                            &&
                            (vendorPurchaseStatus === "{{ \Modules\Booking\Entities\Booking::VENDOR_PURCHASE_STATUS_COMPLETED }}")
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_cancelled") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_REJECTED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CUSTOMER_REJECTED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_PENALTY_FOR_CANCELLATION }}")
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_in_dept") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CREATED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_SENT }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (paymentStatus !== "{{ \Modules\Booking\Entities\Booking::PAYMENT_STATUS_FULLY_PAID }}")
                            &&
                            (vendorPurchaseStatus === "{{ \Modules\Booking\Entities\Booking::VENDOR_PURCHASE_STATUS_COMPLETED }}"
                                || vendorPurchaseStatus === "{{ \Modules\Booking\Entities\Booking::VENDOR_PURCHASE_STATUS_PARTIALLY_PAID }}")
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_customer_balance") {
                        console.log('totalReceiptAmount == ' + totalReceiptAmount);
                        console.log('totalSellPrice == ' + totalSellPrice);
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CREATED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_SENT }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (parseInt(totalReceiptAmount) > parseInt(totalSellPrice))
                        ) {
                            return true;
                        }
                    } else if (selected === "booking_hotel_balance") {
                        if (
                            (bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_CREATED }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_SENT }}"
                                || bookingStatus === "{{ \Modules\Booking\Entities\Booking::BOOKING_STATUS_HOTEL_CONFIRMED }}")
                            &&
                            (parseInt(totalBillAmount) > parseInt(totalBuyPrice))
                        ) {
                            return true;
                        }
                    }
                    return false;
                }
            );

            // Search for booking status
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var selected = $('#booking_status_filter').val();
                    var original = data[12];
                    if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for payment status
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var selected = $('#payment_status_filter').val();
                    var original = data[13];
                    if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for vendor purchase status
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var selected = $('#vendor_purchase_status_filter').val();
                    var original = data[14];
                    if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for hotel confirm code
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#hotel_confirm_code_filter').val();
                    var original = data[15];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for flight code
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#flight_code_filter').val();
                    var original = data[16];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for author
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#author_id_filter').val();
                    var original = data[9];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Event listener to the two range filtering inputs to redraw on input
            $('#booking_number_filter, #campaign_id_filter, #hotel_id_filter, #agency_id_filter, #supplier_id_filter, ' +
                '#customer_id_filter, #hotel_confirm_code_filter, #flight_code_filter, #sale_id_filter, #author_id_filter').keyup( function() {
                table.DataTable().draw();
            });

            $('#date_filter, #start_date_filter, #end_date_filter, ' +
                '#booking_status_filter, #vendor_purchase_status_filter, ' +
                '#payment_status_filter, #booking_type_filter').on('change', function(){
                table.DataTable().draw();
            });

            $('select.selectize-booking-status').on('change', function(){
                var currentValueSelected = $(this).val();
                var bookingId = $(this).data('booking-id');

                var index = table.DataTable().row($(this).parents('tr')).index();
                table.dataTable().fnUpdate(currentValueSelected, index, 12);

                $.ajax({
                    url: '<?= route('admin.booking.booking.update.status') ?>',
                    data: {
                        type: 'booking_status',
                        status: currentValueSelected,
                        id: bookingId
                    },
                    success: function(results) {
                        if (results === 'success') {
                            toastr.success("{{ trans('booking::bookings.messages.change_booking_status_success_message') }}", "{{ trans('booking::bookings.messages.success_title') }}");
                        }
                    },
                    error: function() {

                    }
                })
            });

            $('select.selectize-payment-status').on('change', function(){
                var currentValueSelected = $(this).val();
                var bookingId = $(this).data('booking-id');

                var index = table.DataTable().row($(this).parents('tr')).index();
                table.dataTable().fnUpdate(currentValueSelected, index, 13);

                $.ajax({
                    url: '<?= route('admin.booking.booking.update.status') ?>',
                    data: {
                        type: 'payment_status',
                        status: currentValueSelected,
                        id: bookingId
                    },
                    success: function(results) {
                        if (results === 'success') {
                            toastr.success("{{ trans('booking::bookings.messages.change_payment_status_success_message') }}", "{{ trans('booking::bookings.messages.success_title') }}");
                        }
                    },
                    error: function() {

                    }
                })
            });

            $('select.selectize-vendor-purchase-status').on('change', function(){
                var currentValueSelected = $(this).val();
                var bookingId = $(this).data('booking-id');

                var index = table.DataTable().row($(this).parents('tr')).index();
                table.dataTable().fnUpdate(currentValueSelected, index, 14);

                $.ajax({
                    url: '<?= route('admin.booking.booking.update.status') ?>',
                    data: {
                        type: 'vendor_purchase_status',
                        status: currentValueSelected,
                        id: bookingId
                    },
                    success: function(results) {
                        if (results === 'success') {
                            toastr.success("{{ trans('booking::bookings.messages.change_vendor_purchase_status_success_message') }}", "{{ trans('booking::bookings.messages.success_title') }}");
                        }
                    },
                    error: function() {

                    }
                })
            });

            setTimeout(function(){
                $('select.selectize-payment-status').each(function() {
                    this.selectize.lock();
                });

                $('select.selectize-vendor-purchase-status').each(function(){
                    this.selectize.lock();
                });

                @if($isOperator)
                    $('#author_id_filter').val('{{ $currentUserName }}').keyup();
                @endif
            });
        });
    </script>
@endpush
