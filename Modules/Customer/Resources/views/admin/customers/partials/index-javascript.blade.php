@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.customer.customer.create') ?>" }
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

            // Search for name
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#name_filter').val();
                    var original = data[1];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for email
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#email_filter').val();
                    var original = data[2];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for telephone
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#telephone_filter').val();
                    var original = data[3];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for identity
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#identity_filter').val();
                    var original = data[4];
                    if ( original.toLowerCase().includes(inputted.toLowerCase()) || inputted === "")
                    {
                        return true;
                    }
                    return false;
                }
            );

            // Search for note
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var inputted = $('#note_filter').val();
                    var original = data[7];
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
                        if (dateTypeSelected === 'birthday') {
                            compareValue = data[5];
                        } else if (dateTypeSelected === 'appointment') {
                            compareValue = data[6];
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

            // Event listener to the two range filtering inputs to redraw on input
            $('#name_filter, #email_filter, #telephone_filter, #identity_filter, ' +
                '#note_filter, #author_id_filter').keyup( function() {
                table.DataTable().draw();
            });

            $('#date_filter, #start_date_filter, #end_date_filter').on('change', function(){
                table.DataTable().draw();
            });
        });
    </script>
@endpush
