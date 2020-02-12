<script>
    var xhr;
    var select_hotel, $select_hotel;
    var select_room, $select_room;
    var select_service, $select_service;
    var select_surcharge, $select_surcharge;

    function disableSelectBox() {
        select_room.disable();
        select_room.clearOptions();

        select_service.disable();
        select_service.clearOptions();

        select_surcharge.disable();
        select_surcharge.clearOptions();
    }

    function getValueSelectBoxForRoom(value) {
        select_room.load(function(callback) {
            var endpoint = '<?= route('admin.campaign.campaign.hotel.rooms') ?>';
            @if($editMode)
                endpoint = '@php echo route('admin.campaign.campaign.hotel.rooms', ['id' => $campaign->id]) @endphp';
            @endif
            xhr = $.ajax({
                url: endpoint,
                data: {hotel_ids: value},
                success: function(results) {
                    if (results.length > 0) {
                        select_room.clearOptions();
                        select_room.enable();
                        var rooms = [];
                        @if (!empty(old('room_id')) && count(old('room_id')) > 0)
                            @foreach(old('room_id') as $room)
                                rooms.push("{{$room}}");
                            @endforeach

                            setTimeout(function(){
                                select_room.setValue(rooms);
                                select_room.refreshItems();
                            });
                        @else
                            @if($editMode && count($campaign->rooms()->allRelatedIds()) > 0)
                                @foreach($campaign->rooms()->allRelatedIds() as $room)
                                    rooms.push("{{$room}}");
                                @endforeach

                                setTimeout(function(){
                                    select_room.setValue(rooms);
                                    select_room.refreshItems();
                                });
                            @endif
                        @endif

                        callback(results);
                    } else {
                        select_room.disable();
                        select_room.clearOptions();
                    }
                },
                error: function() {
                    callback();
                }
            })
        });
    }

    function getValueSelectBoxForService(value) {
        select_service.load(function(callback) {
            var endpoint = '<?= route('admin.campaign.campaign.hotel.services') ?>';
            @if($editMode)
                endpoint = '@php echo route('admin.campaign.campaign.hotel.services', ['id' => $campaign->id]) @endphp';
            @endif
            xhr = $.ajax({
                url: endpoint,
                data: {hotel_ids: value},
                success: function(results) {
                    if (results.length > 0) {
                        select_service.clearOptions();
                        select_service.enable();
                        var services = [];
                        @if (!empty(old('service_id')) && count(old('service_id')) > 0)
                            @foreach(old('service_id') as $service)
                                services.push("{{$service}}");
                            @endforeach

                            setTimeout(function(){
                                select_service.setValue(services);
                                select_service.refreshItems();
                            });
                        @else
                            @if($editMode && count($campaign->services()->allRelatedIds()) > 0)
                                @foreach($campaign->services()->allRelatedIds() as $service)
                                    services.push("{{$service}}");
                                @endforeach

                                setTimeout(function(){
                                    select_service.setValue(services);
                                    select_service.refreshItems();
                                });
                            @endif
                        @endif

                        callback(results);
                    } else {
                        select_service.disable();
                        select_service.clearOptions();
                    }
                },
                error: function() {
                    callback();
                }
            })
        });
    }

    function getValueSelectBoxForSurcharge(value) {
        select_surcharge.load(function(callback) {
            var endpoint = '<?= route('admin.campaign.campaign.hotel.surcharges') ?>';
            @if($editMode)
                endpoint = '@php echo route('admin.campaign.campaign.hotel.surcharges', ['id' => $campaign->id]) @endphp';
            @endif
            xhr = $.ajax({
                url: endpoint,
                data: {hotel_ids: value},
                success: function(results) {
                    if (results.length > 0) {
                        select_surcharge.clearOptions();
                        select_surcharge.enable();
                        var surcharges = [];
                        @if (!empty(old('surcharge_id')) && count(old('surcharge_id')) > 0)
                            @foreach(old('surcharge_id') as $surcharge)
                                surcharges.push("{{$surcharge}}");
                            @endforeach

                            setTimeout(function () {
                                select_surcharge.setValue(surcharges);
                                select_surcharge.refreshItems();
                            });
                        @else
                            @if($editMode && count($campaign->surcharges()->allRelatedIds()) > 0)
                                @foreach($campaign->surcharges()->allRelatedIds() as $surcharge)
                                    surcharges.push("{{$surcharge}}");
                                @endforeach

                                setTimeout(function(){
                                    select_surcharge.setValue(surcharges);
                                    select_surcharge.refreshItems();
                                });
                            @endif
                        @endif

                        callback(results);
                    } else {
                        select_surcharge.disable();
                        select_surcharge.clearOptions();
                    }
                },
                error: function() {
                    callback();
                }
            })
        });
    }

    function getValueSelectBox(value) {
        getValueSelectBoxForRoom(value);
        getValueSelectBoxForService(value);
        getValueSelectBoxForSurcharge(value);
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

    function initializeRoomSelect() {
        $select_room = $('.selectize-room').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('campaign::campaigns.form.room_id_empty_option')}}'
        });
        select_room  = $select_room[0].selectize;
    }

    function initializeServiceSelect() {
        $select_service = $('.selectize-service').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('campaign::campaigns.form.service_id_empty_option')}}'
        });
        select_service  = $select_service[0].selectize;
    }

    function initializeSurchargeSelect() {
        $select_surcharge = $('.selectize-surcharge').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('campaign::campaigns.form.surcharge_id_empty_option')}}'
        });
        select_surcharge  = $select_surcharge[0].selectize;
    }

    function populateHotelSelectValueFirstTime() {
        select_hotel = $select_hotel[0].selectize;
        if (select_hotel.items === undefined || select_hotel.items.length == 0) {
            disableSelectBox();
        } else {
            getValueSelectBox(select_hotel.items)
        }
    }

    $(document).ready(function(){
        initializeHotelSelect();
        initializeRoomSelect();
        initializeServiceSelect();
        initializeSurchargeSelect();
        populateHotelSelectValueFirstTime();
    });
</script>
