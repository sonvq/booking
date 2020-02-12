<?php $locale = locale(); ?>
<script type="text/javascript">
    function parseDate(str) {
        var dmy = str.split('/');
        return new Date(dmy[2], dmy[1]-1, dmy[0]);
    }
    function datediff(first, second) {
        return Math.round((second-first)/(1000*60*60*24));
    }

    $( document ).ready(function() {
        $('.reset_filter').on('click', function(){
            $(this).parent().parent('.table_filter_container').find('input').each(function(){
                $(this).val('');
            });

            $(this).parent().parent('.table_filter_container').find('select').each(function(){
                $(this).val('');
            });

            tableBill.DataTable().draw();
        });

        $(document).keypressAction({
            actions: [
                { key: 'c', route: "<?= route('admin.bill.bill.create') ?>" }
            ]
        });

        var tableBill = $('.data-table').dataTable({
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

        // Search for unique number
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var inputted = $('#unique_number_filter').val();
                var original = data[1];
                if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for amount
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var inputted = $('#amount_filter').val();
                var original = data[4];
                if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for booking number
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var inputted = $('#booking_number_filter').val();
                var original = data[2];
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
                var original = data[8];
                if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for type
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var selected = $('#type_filter').val();
                var original = data[9];

                if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for payment type
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var selected = $('#payment_type_filter').val();
                var original = data[10];

                if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for status
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var selected = $('#status_filter').val();
                var original = data[11];

                if (original.toLowerCase() === selected.toLowerCase() || selected === "")
                {
                    return true;
                }
                return false;
            }
        );

        // Search for date
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var startDateInputted = $('#start_date_filter').val();
                var endDateInputted = $('#end_date_filter').val();

                if (startDateInputted === "" && endDateInputted === "") {
                    return true;
                }
                var compareValue = data[7];

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
                return false;
            }
        );

        // Event listener to the two range filtering inputs to redraw on input
        $('#unique_number_filter, #booking_number_filter, #amount_filter, #author_id_filter').keyup( function() {
            tableBill.DataTable().draw();
        });

        $('#type_filter, #payment_type_filter, #status_filter, #start_date_filter, #end_date_filter').on('change', function(){
            tableBill.DataTable().draw();
        });

    });
</script>