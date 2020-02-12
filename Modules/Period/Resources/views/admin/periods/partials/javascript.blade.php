<script>
    var xhr;
    var select_hotel, $select_hotel;
    var select_campaign, $select_campaign;

    function remove_date_row(obj) {
        var this_temp = jQuery(obj);
        var r = confirm("{{ trans('period::periods.form.confirm_delete_date_row') }}");
        if (r == true) {
            this_temp.parent().parent().remove();
        }
    }

    function disableSelectBox() {
        select_campaign.disable();
        select_campaign.clearOptions();
    }

    function getValueSelectBox(value) {
        getValueSelectBoxForCampaign(value);
    }

    function populateHotelSelectValueFirstTime() {
        select_hotel = $select_hotel[0].selectize;
        if (select_hotel.items === undefined || select_hotel.items.length == 0) {
            disableSelectBox();
        } else {
            getValueSelectBox(select_hotel.items)
        }
    }

    function getValueSelectBoxForCampaign(value) {
        select_campaign.load(function(callback) {
            var endpoint = '<?= route('admin.period.period.hotel.campaigns') ?>';
            @if($editMode)
                endpoint = '@php echo route('admin.period.period.hotel.campaigns', ['id' => $period->id]) @endphp';
            @endif
            xhr = $.ajax({
                url: endpoint,
                data: {hotel_ids: value},
                success: function(results) {
                    if (results.length > 0) {
                        select_campaign.clearOptions();
                        select_campaign.enable();

                        @if (!empty(old('campaign_id')))
                            setTimeout(function(){
                                select_campaign.setValue("{{old('campaign_id')}}");
                                select_campaign.refreshItems();
                            });
                        @else
                            @if($editMode)
                                setTimeout(function(){
                                    select_campaign.setValue("{{ $period->campaign_id }}");
                                    select_campaign.refreshItems();
                                });
                            @endif
                        @endif

                        callback(results);
                    } else {
                        select_campaign.disable();
                        select_campaign.clearOptions();
                    }
                },
                error: function() {
                    callback();
                }
            })
        });
    }

    function initializeHotelSelect() {
        $select_hotel = $('.selectize-hotel').selectize({
            plugins: ['remove_button'],
            onChange: function(value) {
                if (value === null) {
                    disableSelectBox();
                } else {
                    getValueSelectBox(value);
                }
            },
        });
    }

    function initializeCampaignSelect() {
        $select_campaign = $('.selectize-campaign').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('period::periods.form.campaign_id_empty_option')}}'
        });
        select_campaign  = $select_campaign[0].selectize;
    }

    $(document).ready(function(){
        $(".add-new-date-row").on('click', function(){
            $(".date-range-container").append(
                `<div class="row"> \
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <input class="form-control datepicker" placeholder="{{ trans('period::periods.form.start_date') }}" name="start_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <input class="form-control datepicker" placeholder="{{ trans('period::periods.form.end_date') }}" name="end_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <button type="button" class="remove-row" href="javascript:;" onclick="remove_date_row(this);">\
                            <i class="fa fa-remove"></i>\
                        </button>\
                    </div>\
                </div>`
            );

            /**
             * Dont remove this block
             */
            $( ".datepicker").datepicker({
                format: 'dd/mm/yyyy',
            });
        });

        initializeHotelSelect();
        initializeCampaignSelect();
        populateHotelSelectValueFirstTime();
    })
</script>


