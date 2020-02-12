<script>
    function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    var xhr;
    var select_hotel, $select_hotel;
    var select_campaign, $select_campaign;
    var checkin_date, checkout_date;

    function remove_row(obj, confirmMessage) {
        var this_temp = jQuery(obj);
        var r = confirm(confirmMessage);
        if (r == true) {
            this_temp.parent().parent().remove();
        }
        enableOrDisableBuyPriceSellPrice();
    }

    /**
     * Disable select box
     */
    function disableCampaignSelectBox() {
        select_campaign.disable();
        select_campaign.clearOptions();
    }
    function disableRoomSelectBox() {
        setTimeout(function(){
            $('select.selectize-room').each(function(){
                this.selectize.disable();
                this.selectize.clearOptions();
            });
        });
    }
    function disableServiceSelectBox() {
        setTimeout(function(){
            $('select.selectize-service').each(function(){
                this.selectize.disable();
                this.selectize.clearOptions();
            });
        });
    }
    function disableSurchargeSelectBox() {
        setTimeout(function(){
            $('select.selectize-surcharge').each(function(){
                this.selectize.disable();
                this.selectize.clearOptions();
            });
        });
    }

    /**
     * Populate hotel value first time
     */
    function populateHotelSelectValueFirstTime() {
        console.log('populateHotelSelectValueFirstTime');
        select_hotel = $select_hotel[0].selectize;
        if (select_hotel.items === undefined || select_hotel.items.length == 0) {
            disableValueSelectBox()
        } else {
            getValueSelectBox()
        }
    }
    function getValueSelectBox() {
        console.log('getValueSelectBox');
        getValueSelectBoxForCampaign();
        getValueSelectBoxForRoom();
        getValueSelectBoxForService();
        getValueSelectBoxForSurcharge();
        @if($editMode)
            loadDataForCod();
        @endif
    }
    function disableValueSelectBox() {
        console.log('disableValueSelectBox');
        disableCampaignSelectBox();
        disableRoomSelectBox();
        disableServiceSelectBox();
        disableSurchargeSelectBox();
    }

    /**
     * Load ajax data for room, service, surcharge, sell-buy price, campaign
     */
    function loadDataForCod() {
        console.log('loadDataForCod');
        var hotel_selected = select_hotel.getValue();
        var checkin_date_value = checkin_date.val();
        var customer_selected = $('select.selectize-customer')[0].selectize.getValue();

        if (hotel_selected > 0 && customer_selected > 0 && checkin_date_value !== '') {
            xhr = $.ajax({
                url: '<?= route('admin.booking.booking.cod') ?>',
                data: {
                    hotel_id: hotel_selected,
                    customer_id: customer_selected,
                    checkin_date: checkin_date_value,
                },
                success: function(results) {
                    $('#booking_cod').html(results);
                },
                error: function() {

                }
            })
        }
    }
    function loadDataSelectBoxForRoom(object, index = -1, bindOldData = false) {
        console.log('loadDataSelectBoxForRoom');
        var hotel_selected = select_hotel.getValue();
        var campaign_selected = select_campaign.getValue();
        var checkin_date_value = checkin_date.val();
        var customer_selected = $('select.selectize-customer')[0].selectize.getValue();

        if (checkin_date_value !== '' && hotel_selected > 0 && campaign_selected > 0 && customer_selected > 0) {
            object.load(function(callback) {
                xhr = $.ajax({
                    url: '<?= route('admin.booking.booking.hotel.rooms') ?>',
                    data: {
                        hotel_id: hotel_selected,
                        campaign_id: campaign_selected,
                        checkin_date: checkin_date_value,
                        customer_id: customer_selected
                    },
                    success: function(results) {
                        if (results.length > 0) {
                            object.clearOptions();
                            object.enable();
                            var rooms = [];
                            if (bindOldData === true) {
                                @if (!empty(old('room_id')) && count(old('room_id')) > 0)
                                    @foreach(old('room_id') as $room)
                                        rooms.push("{{$room}}");
                                    @endforeach

                                    setTimeout(function(){
                                        object.setValue(rooms[index]);
                                        object.refreshItems();
                                    });
                                @else
                                    @if($editMode)
                                        @foreach($rooms as $room)
                                            rooms.push("{{ $room->id }}");
                                        @endforeach

                                        setTimeout(function(){
                                            object.setValue(rooms[index]);
                                            object.refreshItems();
                                        });
                                    @endif
                                @endif
                            }

                            callback(results);
                        } else {
                            object.disable();
                            object.clearOptions();
                        }
                    },
                    error: function() {
                        callback();
                    }
                })
            });
        } else {
            disableRoomSelectBox();
        }
    }
    function loadDataSelectBoxForService(object, index = -1, bindOldData = false) {
        console.log('loadDataSelectBoxForService');
        var hotel_selected = select_hotel.getValue();
        var campaign_selected = select_campaign.getValue();

        if (hotel_selected > 0 && campaign_selected > 0) {
            object.load(function(callback) {
                xhr = $.ajax({
                    url: '<?= route('admin.booking.booking.hotel.services') ?>',
                    data: {
                        hotel_id: hotel_selected,
                        campaign_id: campaign_selected
                    },
                    success: function(results) {
                        if (results.length > 0) {
                            object.clearOptions();
                            object.enable();
                            var services = [];
                            if (bindOldData === true) {
                                @if (!empty(old('service_id')) && count(old('service_id')) > 0)
                                    @foreach(old('service_id') as $service)
                                        services.push("{{$service}}");
                                    @endforeach

                                    setTimeout(function(){
                                        object.setValue(services[index]);
                                        object.refreshItems();
                                    });
                                @else
                                    @if($editMode)
                                        @foreach($services as $service)
                                            services.push("{{ $service-> id }}");
                                        @endforeach

                                        setTimeout(function(){
                                            object.setValue(services[index]);
                                            object.refreshItems();
                                        });
                                    @endif
                                @endif
                            }

                            callback(results);
                        } else {
                            object.disable();
                            object.clearOptions();
                        }
                    },
                    error: function() {
                        callback();
                    }
                })
            });
        } else {
            disableServiceSelectBox();
        }
    }
    function loadDataSelectBoxForSurcharge(object, index = -1, bindOldData = false) {
        console.log('loadDataSelectBoxForSurcharge');
        var hotel_selected = select_hotel.getValue();
        var campaign_selected = select_campaign.getValue();

        if (hotel_selected > 0 && campaign_selected > 0) {
            object.load(function(callback) {
                xhr = $.ajax({
                    url: '<?= route('admin.booking.booking.hotel.surcharges') ?>',
                    data: {
                        hotel_id: hotel_selected,
                        campaign_id: campaign_selected
                    },
                    success: function(results) {
                        if (results.length > 0) {
                            object.clearOptions();
                            object.enable();
                            var surcharges = [];
                            if (bindOldData === true) {
                                @if (!empty(old('surcharge_id')) && count(old('surcharge_id')) > 0)
                                    @foreach(old('surcharge_id') as $surcharge)
                                        surcharges.push("{{$surcharge}}");
                                    @endforeach

                                    setTimeout(function(){
                                        object.setValue(surcharges[index]);
                                        object.refreshItems();
                                    });
                                @else
                                    @if($editMode)
                                        @foreach($surcharges as $surcharge)
                                            surcharges.push("{{ $surcharge->id }}");
                                        @endforeach

                                        setTimeout(function(){
                                            object.setValue(surcharges[index]);
                                            object.refreshItems();
                                        });
                                    @endif
                                @endif
                            }

                            callback(results);
                        } else {
                            object.disable();
                            object.clearOptions();
                        }
                    },
                    error: function() {
                        callback();
                    }
                })
            });
        } else {
            disableSurchargeSelectBox();
        }
    }

    function parseDate(str) {
        var dmy = str.split('/');
        return new Date(dmy[2], dmy[1]-1, dmy[0]);
    }

    function datediff(first, second) {
        return Math.round((second-first)/(1000*60*60*24));
    }

    function loadDataForSellPriceBuyPrice() {
        console.log('loadDataForSellPriceBuyPrice');
        var hotel_selected = select_hotel.getValue();
        var campaign_selected = select_campaign.getValue();
        var checkin_date_value = checkin_date.val();
        var customer_selected = $('select.selectize-customer')[0].selectize.getValue();
        var agency_selected = $('select.selectize-agency')[0].selectize.getValue();
        var supplier_selected = $('select.selectize-supplier')[0].selectize.getValue();
        var is_adjust_surcharge = 0;
        if ($("#is_adjust_surcharge").prop('checked') == true) {
            is_adjust_surcharge = 1;
        }

        if (checkin_date_value !== '' && hotel_selected > 0 && campaign_selected > 0 && customer_selected > 0) {
            xhr = $.ajax({
                url: '<?= route('admin.booking.booking.sell.buy.price') ?>',
                data: {
                    hotel_id: hotel_selected,
                    campaign_id: campaign_selected,
                    checkin_date: checkin_date_value,
                    customer_id: customer_selected,
                    agency_id: agency_selected,
                    is_adjust_surcharge: is_adjust_surcharge,
                    supplier_id: supplier_selected
                },
                success: function(results) {
                    var total_price = 0;
                    var total_buy_price = 0;
                    var total_sell_price = 0;
                    var total_profit = 0;

                    $('select.selectize-room').each(function(index){
                        var currentRoomSelectize = this.selectize;
                        var currentRoomSelectedId = currentRoomSelectize.getValue();

                        if (currentRoomSelectedId > 0 && results['room_price'] !== 0) {
                            $(this).closest('.row').find('input[name="buy_price[]"]').val(addCommas(results['room_price'][currentRoomSelectedId]['buy_price']));
                            $(this).closest('.row').find('input[name="sell_price[]"]').val(addCommas(results['room_price'][currentRoomSelectedId]['sell_price']));

                            if ($(this).closest('.row').find('input[name="quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="end_date[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['room_price'][currentRoomSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + results['room_price'][currentRoomSelectedId]['buy_price'] * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + results['room_price'][currentRoomSelectedId]['sell_price'] * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                }
                            }
                        } else {
                            $(this).closest('.row').find('input[name="buy_price[]"]').val('');
                            $(this).closest('.row').find('input[name="sell_price[]"]').val('');
                        }
                    });
                    $('select.selectize-service').each(function(index){
                        var currentServiceSelectize = this.selectize;
                        var currentServiceSelectedId = currentServiceSelectize.getValue();

                        if (currentServiceSelectedId > 0 && results['service_price'] !== 0) {
                            $(this).closest('.row').find('input[name="service_buy_price[]"]').val(addCommas(results['service_price'][currentServiceSelectedId]['buy_price']));
                            $(this).closest('.row').find('input[name="service_sell_price[]"]').val(addCommas(results['service_price'][currentServiceSelectedId]['sell_price']));

                            if ($(this).closest('.row').find('input[name="service_quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_end_date[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="service_start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="service_end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['service_price'][currentServiceSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + results['service_price'][currentServiceSelectedId]['buy_price'] * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + results['service_price'][currentServiceSelectedId]['sell_price'] * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                }
                            }
                        } else {
                            $(this).closest('.row').find('input[name="service_buy_price[]"]').val('');
                            $(this).closest('.row').find('input[name="service_sell_price[]"]').val('');
                        }
                    });
                    $('select.selectize-surcharge').each(function(index){
                        var currentSurchargeSelectize = this.selectize;
                        var currentSurchargeSelectedId = currentSurchargeSelectize.getValue();

                        if (currentSurchargeSelectedId > 0 && results['surcharge_price'] !== 0) {
                            $(this).closest('.row').find('input[name="surcharge_buy_price[]"]').val(addCommas(results['surcharge_price'][currentSurchargeSelectedId]['buy_price']));
                            $(this).closest('.row').find('input[name="surcharge_sell_price[]"]').val(addCommas(results['surcharge_price'][currentSurchargeSelectedId]['sell_price']));

                            if ($(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_end_date[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="surcharge_start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="surcharge_end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['surcharge_price'][currentSurchargeSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + results['surcharge_price'][currentSurchargeSelectedId]['buy_price'] * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + results['surcharge_price'][currentSurchargeSelectedId]['sell_price'] * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                }
                            }
                        } else {
                            $(this).closest('.row').find('input[name="surcharge_buy_price[]"]').val('');
                            $(this).closest('.row').find('input[name="surcharge_sell_price[]"]').val('');
                        }
                    });

                    total_profit = total_sell_price - total_buy_price;
                    $('#total_price').val(addCommas(total_price));
                    $('#total_buy_price').val(addCommas(total_buy_price));
                    $('#total_sell_price').val(addCommas(total_sell_price));
                    $('#total_profit').val(addCommas(total_profit));

                },
                error: function() {
                    callback();
                }
            })
        }
    }

    /**
     *  Get value select box for room, service, surcharge, sell-buy price, campaign
     */
    function getValueSelectBoxForCampaign() {
        console.log('getValueSelectBoxForCampaign');
        var checkin_date_value = checkin_date.val();
        var customer_selected = $('select.selectize-customer')[0].selectize.getValue();
        var hotel_selected = select_hotel.getValue();

        if (checkin_date_value !== '' && customer_selected !== '' && hotel_selected > 0) {
            select_campaign.load(function(callback) {
                xhr = $.ajax({
                    url: '<?= route('admin.booking.booking.hotel.campaigns') ?>',
                    data: {
                        hotel_id: hotel_selected,
                        checkin_date: checkin_date_value,
                        customer_id: customer_selected
                    },
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
                                        select_campaign.setValue("{{ $booking->campaign_id }}");
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
        } else {
            disableCampaignSelectBox();
        }
    }
    function getValueSelectBoxForRoom() {
        console.log('getValueSelectBoxForRoom');
        $('select.selectize-room').each(function(index){
            var currentRoomSelectize = this.selectize;
            loadDataSelectBoxForRoom(currentRoomSelectize, index, true);
        });
    }
    function getValueSelectBoxForService() {
        console.log('getValueSelectBoxForService');
        $('select.selectize-service').each(function(index){
            var currentServiceSelectize = this.selectize;
            loadDataSelectBoxForService(currentServiceSelectize, index, true);
        });
    }
    function getValueSelectBoxForSurcharge() {
        console.log('getValueSelectBoxForSurcharge');
        $('select.selectize-surcharge').each(function(index){
            var currentSurchargeSelectize = this.selectize;
            loadDataSelectBoxForSurcharge(currentSurchargeSelectize, index, true);
        });
    }

    /**
     * Create selectize object
     */
    function createRoomSelectize(object) {
        $(object).selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('booking::bookings.form.room_id_empty_option')}}'
        });
    }
    function createServiceSelectize(object) {
        $(object).selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('booking::bookings.form.service_id_empty_option')}}'
        });
    }
    function createSurchargeSelectize(object) {
        $(object).selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('booking::bookings.form.surcharge_id_empty_option')}}'
        });
    }

    /**
     * Initialize Select
     */
    function initializeRoomSelect() {
        console.log('initializeRoomSelect');
        $('select.selectize-room').each(function(){
            createRoomSelectize(this);
        });
    }
    function initializeServiceSelect() {
        console.log('initializeServiceSelect');
        $('select.selectize-service').each(function(){
            createServiceSelectize(this);
        });
    }
    function initializeSurchargeSelect() {
        console.log('initializeSurchargeSelect');
        $('select.selectize-surcharge').each(function(){
            createSurchargeSelectize(this);
        });
    }
    function initializeCustomerSelect() {
        console.log('initializeCustomerSelect');
        $('.selectize-customer').selectize();
    }
    function initializeAgencySelect() {
        console.log('initializeAgencySelect');
        $('.selectize-agency').selectize();
    }
    function initializeSupplierSelect() {
        console.log('initializeSupplierSelect');
        $('.selectize-supplier').selectize();
    }
    function initializeHotelSelect() {
        console.log('initializeHotelSelect');
        $select_hotel = $('.selectize-hotel').selectize({
            onChange: function(value) {
                if (value === null) {
                    disableValueSelectBox()
                } else {
                    getValueSelectBox();
                }
            },
        });
    }
    function initializeCampaignSelect() {
        console.log('initializeCampaignSelect');
        $select_campaign = $('.selectize-campaign').selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('booking::bookings.form.campaign_id_empty_option')}}'
        });
        select_campaign  = $select_campaign[0].selectize;
    }

    function manuallyCalculateTotalPrice() {
        console.log('manuallyCalculateTotalPrice');
        var hotel_selected = select_hotel.getValue();
        var campaign_selected = select_campaign.getValue();
        var checkin_date_value = checkin_date.val();
        var customer_selected = $('select.selectize-customer')[0].selectize.getValue();
        var agency_selected = $('select.selectize-agency')[0].selectize.getValue();
        var supplier_selected = $('select.selectize-supplier')[0].selectize.getValue();
        var is_adjust_surcharge = 0;
        if ($("#is_adjust_surcharge").prop('checked') == true) {
            is_adjust_surcharge = 1;
        }

        if (checkin_date_value !== '' && hotel_selected > 0 && campaign_selected > 0 && customer_selected > 0) {
            xhr = $.ajax({
                url: '<?= route('admin.booking.booking.sell.buy.price') ?>',
                data: {
                    hotel_id: hotel_selected,
                    campaign_id: campaign_selected,
                    checkin_date: checkin_date_value,
                    customer_id: customer_selected,
                    agency_id: agency_selected,
                    is_adjust_surcharge: is_adjust_surcharge,
                    supplier_id: supplier_selected
                },
                success: function(results) {
                    var total_price = 0;
                    var total_buy_price = 0;
                    var total_sell_price = 0;
                    var total_profit = 0;

                    $('select.selectize-room').each(function(index){
                        var currentRoomSelectize = this.selectize;
                        var currentRoomSelectedId = currentRoomSelectize.getValue();

                        if (currentRoomSelectedId > 0 && results['room_price'] !== 0) {
                            if ($(this).closest('.row').find('input[name="quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="end_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="buy_price[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="sell_price[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['room_price'][currentRoomSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + $(this).closest('.row').find('input[name="buy_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + $(this).closest('.row').find('input[name="sell_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="quantity[]"]').val() * night;
                                }
                            }
                        }
                    });
                    $('select.selectize-service').each(function(index){
                        var currentServiceSelectize = this.selectize;
                        var currentServiceSelectedId = currentServiceSelectize.getValue();

                        if (currentServiceSelectedId > 0 && results['service_price'] !== 0) {
                            if ($(this).closest('.row').find('input[name="service_quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_end_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_buy_price[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="service_sell_price[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="service_start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="service_end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['service_price'][currentServiceSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + $(this).closest('.row').find('input[name="service_buy_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + $(this).closest('.row').find('input[name="service_sell_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="service_quantity[]"]').val() * night;
                                }
                            }
                        }
                    });
                    $('select.selectize-surcharge').each(function(index){
                        var currentSurchargeSelectize = this.selectize;
                        var currentSurchargeSelectedId = currentSurchargeSelectize.getValue();

                        if (currentSurchargeSelectedId > 0 && results['surcharge_price'] !== 0) {
                            if ($(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_start_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_end_date[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_buy_price[]"]').val() != ""
                                && $(this).closest('.row').find('input[name="surcharge_sell_price[]"]').val() != "") {

                                var night = datediff(parseDate($(this).closest('.row').find('input[name="surcharge_start_date[]"]').val()), parseDate($(this).closest('.row').find('input[name="surcharge_end_date[]"]').val()));

                                if (night > 0) {
                                    total_price = total_price + results['surcharge_price'][currentSurchargeSelectedId]['actual_price'] * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                    total_buy_price = total_buy_price + $(this).closest('.row').find('input[name="surcharge_buy_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                    total_sell_price = total_sell_price + $(this).closest('.row').find('input[name="surcharge_sell_price[]"]').val().replace(/\,/g,'') * $(this).closest('.row').find('input[name="surcharge_quantity[]"]').val() * night;
                                }
                            }
                        }
                    });

                    total_profit = total_sell_price - total_buy_price;
                    $('#total_price').val(addCommas(total_price));
                    $('#total_buy_price').val(addCommas(total_buy_price));
                    $('#total_sell_price').val(addCommas(total_sell_price));
                    $('#total_profit').val(addCommas(total_profit));

                },
                error: function() {
                    callback();
                }
            })
        }
    }

    /**
     * Binding event for elements
     */
    function bindEventForElements() {
        console.log('bindEventForElements');
        $('select.selectize-customer').on('change', function(){
            console.log('select.selectize-customer change');
            getValueSelectBoxForRoom();
            enableOrDisableBuyPriceSellPrice();
            @if($editMode)
                loadDataForCod();
            @endif
        });

        $('select.selectize-supplier').on('change', function(){
            console.log('select.selectize-supplier change');
            enableOrDisableBuyPriceSellPrice();
        });

        select_campaign.on('change', function(){
            console.log('select_campaign change');
            getValueSelectBoxForRoom();
            getValueSelectBoxForService();
            getValueSelectBoxForSurcharge();
            enableOrDisableBuyPriceSellPrice();
        });

        checkin_date.on('change', function(){
            console.log('checkin_date change');
            getValueSelectBoxForCampaign();
            getValueSelectBoxForRoom();
            enableOrDisableBuyPriceSellPrice();
            @if($editMode)
                loadDataForCod();
            @endif
        });
        $('select.selectize-customer').on('change', function(){
            console.log('selectize-customer change');
            getValueSelectBoxForCampaign();
        });

        $('#is_adjust_price' +
            ', #is_adjust_surcharge' +
            ', input[name="start_date[]"]' +
            ', input[name="end_date[]"]' +
            ', input[name="quantity[]"]' +
            ', input[name="service_start_date[]"]' +
            ', input[name="service_end_date[]"]' +
            ', input[name="service_quantity[]"]' +
            ', input[name="surcharge_start_date[]"]' +
            ', input[name="surcharge_end_date[]"]' +
            ', input[name="surcharge_quantity[]"]' +
            ', select.selectize-room' +
            ', select.selectize-agency' +
            ', select.selectize-service' +
            ', select.selectize-surcharge').on('change', function(){
            enableOrDisableBuyPriceSellPrice();
        });

        $('input[name="buy_price[]"]' +
            ', input[name="sell_price[]"]' +
            ', input[name="service_buy_price[]"]' +
            ', input[name="service_sell_price[]"]' +
            ', input[name="surcharge_buy_price[]"]' +
            ', input[name="surcharge_sell_price[]"]').on('change', function(){
            enableOrDisableBuyPriceSellPrice();
        });

        $(".add-new-room-row").on('click', function(){
            $(".room-list-container").append(
                `<div class="row">\
                    <div class="col-md-2">\
                        <div class="form-group ">\
                            <select class="selectize-room" name="room_id[]"></select>\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.quantity') }}" name="quantity[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.start_date') }}" name="start_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.end_date') }}" name="end_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.buy_price') }}" name="buy_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.sell_price') }}" name="sell_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">\
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

            $('select.selectize-room').each(function(){
                if (typeof this.selectize === 'undefined') {
                    createRoomSelectize(this);
                    var createdRoomSelect = this.selectize;
                    createdRoomSelect.disable();
                    createdRoomSelect.clearOptions();

                    loadDataSelectBoxForRoom(createdRoomSelect);

                    createdRoomSelect.on('change', function(){
                        enableOrDisableBuyPriceSellPrice();
                    });
                }
            });

            $('input[name="start_date[]"]' +
                ', input[name="end_date[]"]' +
                ', input[name="quantity[]"]' +
                ', input[name="buy_price[]"]' +
                ', input[name="sell_price[]"]').on('change', function(){
                enableOrDisableBuyPriceSellPrice();
            });

            enableOrDisableBuyPriceSellPrice(false);
        });

        $(".add-new-service-row").on('click', function(){
            $(".service-list-container").append(
                `<div class="row">\
                    <div class="col-md-2">\
                        <div class="form-group ">\
                            <select class="selectize-service" name="service_id[]"></select>\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.service_quantity') }}" name="service_quantity[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.service_start_date') }}" name="service_start_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.service_end_date') }}" name="service_end_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.service_buy_price') }}" name="service_buy_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.service_sell_price') }}" name="service_sell_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">\
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

            $('select.selectize-service').each(function(){
                if (typeof this.selectize === 'undefined') {
                    createServiceSelectize(this);
                    var createdServiceSelect = this.selectize;
                    createdServiceSelect.disable();
                    createdServiceSelect.clearOptions();

                    loadDataSelectBoxForService(createdServiceSelect);

                    createdServiceSelect.on('change', function(){
                        enableOrDisableBuyPriceSellPrice();
                    });
                }
            });
            $('input[name="service_start_date[]"]' +
                ', input[name="service_end_date[]"]' +
                ', input[name="service_quantity[]"]' +
                ', input[name="service_buy_price[]"]' +
                ', input[name="service_sell_price[]"]').on('change', function(){
                enableOrDisableBuyPriceSellPrice();
            });

            enableOrDisableBuyPriceSellPrice(false);
        });

        $(".add-new-surcharge-row").on('click', function(){
            $(".surcharge-list-container").append(
                `<div class="row">\
                    <div class="col-md-2">\
                        <div class="form-group ">\
                            <select class="selectize-surcharge" name="surcharge_id[]"></select>\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.surcharge_quantity') }}" name="surcharge_quantity[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.surcharge_start_date') }}" name="surcharge_start_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control datepicker" autocomplete="off" placeholder="{{ trans('booking::bookings.form.surcharge_end_date') }}" name="surcharge_end_date[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.surcharge_buy_price') }}" name="surcharge_buy_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <input class="form-control" placeholder="{{ trans('booking::bookings.form.surcharge_sell_price') }}" name="surcharge_sell_price[]" type="text">\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">\
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

            $('select.selectize-surcharge').each(function(){
                if (typeof this.selectize === 'undefined') {
                    createSurchargeSelectize(this);
                    var createdSurchargeSelect = this.selectize;
                    createdSurchargeSelect.disable();
                    createdSurchargeSelect.clearOptions();

                    loadDataSelectBoxForSurcharge(createdSurchargeSelect);

                    createdSurchargeSelect.on('change', function(){
                        enableOrDisableBuyPriceSellPrice();
                    });
                }
            });
            $('input[name="surcharge_start_date[]"]' +
                ', input[name="surcharge_end_date[]"]' +
                ', input[name="surcharge_quantity[]"]' +
                ', input[name="surcharge_buy_price[]"]' +
                ', input[name="surcharge_sell_price[]"]').on('change', function(){
                enableOrDisableBuyPriceSellPrice();
            });

            enableOrDisableBuyPriceSellPrice(false);
        });
    }

    function enableOrDisableBuyPriceSellPrice(loadData = true) {
        console.log('enableOrDisableBuyPriceSellPrice');
        if($("#is_adjust_price").prop('checked') == true){
            $('input[name="buy_price[]"], input[name="sell_price[]"]' +
                ', input[name="service_buy_price[]"], input[name="service_sell_price[]"]' +
                ', input[name="surcharge_buy_price[]"], input[name="surcharge_sell_price[]"]' +
                '').each(function(){
                $(this).prop('readonly', false);
            });
            setTimeout(function(){
                manuallyCalculateTotalPrice();
            });
        } else {
            $('input[name="buy_price[]"], input[name="sell_price[]"]' +
                ', input[name="service_buy_price[]"], input[name="service_sell_price[]"]' +
                ', input[name="surcharge_buy_price[]"], input[name="surcharge_sell_price[]"]' +
                '').each(function(){
                $(this).prop('readonly', true);
            });

            // automatically calculate buy_price and sell_price
            if(loadData) {
                setTimeout(function(){
                    loadDataForSellPriceBuyPrice();
                });
            }
        }
    }

    $(document).ready(function() {
        checkin_date = $('.checkin_date');
        checkout_date = $('.checkout_date');

        /**
         * Initialize elements and events
         */
        initializeCampaignSelect();
        initializeRoomSelect();
        initializeServiceSelect();
        initializeSurchargeSelect();
        initializeAgencySelect();
        initializeSupplierSelect();
        initializeCustomerSelect();
        initializeHotelSelect();

        /**
         * Get value first time on submit
         */
        populateHotelSelectValueFirstTime();

        setTimeout(function(){
            bindEventForElements();
        });

        enableOrDisableBuyPriceSellPrice(false);

        setTimeout(function() {
            @if($editMode)
                $('select.selectize-payment-status')[0].selectize.lock();
                $('select.selectize-vendor-purchase-status')[0].selectize.lock();
            @endif
        });
    });
</script>
