<script>
    var xhr;
    var select_hotel, $select_hotel;
    var select_room, $select_room;
    var select_campaign, $select_campaign;

    function disableSelectBox() {
        select_room.disable();
        select_room.clearOptions();

        select_hotel.disable();
        select_hotel.clearOptions();
    }

    function getValueSelectBoxForRoom(hotel_id) {
        var campaign_id = select_campaign.getValue();
        if (campaign_id !== "") {
            select_room.load(function(callback) {
                var endpoint = '<?= route('admin.promotion.promotion.campaign.rooms') ?>';
                xhr = $.ajax({
                    url: endpoint,
                    data: {campaign_id: campaign_id, hotel_id: hotel_id},
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
                            @if($editMode && count($promotion->rooms()->allRelatedIds()) > 0)
                            @foreach($promotion->rooms()->allRelatedIds() as $room)
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
    }
    function getValueSelectBoxForHotel(campaign_id) {
        select_hotel.load(function(callback) {
            var endpoint = '<?= route('admin.promotion.promotion.campaign.hotels') ?>';
            xhr = $.ajax({
                url: endpoint,
                data: {campaign_id: campaign_id},
                success: function(results) {
                    if (results.length > 0) {
                        select_hotel.clearOptions();
                        select_hotel.enable();
                        var hotels = [];
                        @if (!empty(old('hotel_id')) && count(old('hotel_id')) > 0)
                            @foreach(old('hotel_id') as $hotel)
                                hotels.push("{{$hotel}}");
                            @endforeach

                            setTimeout(function(){
                                select_hotel.setValue(hotels);
                                select_hotel.refreshItems();
                            });
                        @else
                            @if($editMode && count($promotion->hotels()->allRelatedIds()) > 0)
                                @foreach($promotion->hotels()->allRelatedIds() as $hotel)
                                    hotels.push("{{$hotel}}");
                                @endforeach

                                setTimeout(function(){
                                    select_hotel.setValue(hotels);
                                    select_hotel.refreshItems();
                                });
                            @endif
                        @endif

                        callback(results);
                    } else {
                        select_hotel.disable();
                        select_hotel.clearOptions();
                    }
                },
                error: function() {
                    callback();
                }
            })
        });
    }

    function initializeCampaignSelect() {
        $select_campaign = $('.selectize-campaign').selectize({
            onChange: function(value) {
                if (value === null) {
                    disableSelectBox();
                } else {
                    getValueSelectBoxForHotel(value);
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
            placeholder: '{{trans('promotion::promotions.form.room_id_empty_option')}}'
        });
        select_room  = $select_room[0].selectize;
    }
    function initializeHotelSelect() {
        $select_hotel = $('.selectize-hotel').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: '{{trans('promotion::promotions.form.hotel_id_empty_option')}}',
            onChange: function(value) {
                if (value === null) {
                    select_room.disable();
                    select_room.clearOptions();
                } else {
                    getValueSelectBoxForRoom(value);
                }
            },
        });
        select_hotel  = $select_hotel[0].selectize;
    }

    function populateCampaignSelectValueFirstTime() {
        select_campaign = $select_campaign[0].selectize;
        var selectedValue = select_campaign.getValue();

        if (selectedValue === "") {
            disableSelectBox();
        } else {
            getValueSelectBoxForHotel(selectedValue);
        }
    }

    $(document).ready(function(){
        initializeCampaignSelect();
        initializeHotelSelect();
        initializeRoomSelect();

        populateCampaignSelectValueFirstTime();
    });
</script>
