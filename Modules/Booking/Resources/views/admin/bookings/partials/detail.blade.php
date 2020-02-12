<div class="tab-pane" id="tab_2-2">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.booking_number') }}</label>
                    <p>{{ $booking->booking_number }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.author_id') }}</label>
                    @if ($booking->author)
                        <p>{{ $booking->author->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.cod') }}</label>
                    <p id="booking_cod">{{ $codDate }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.booking_status') }}</label>
                    @if (isset($bookingStatuses[$booking->booking_status]))
                        <p>{{ $bookingStatuses[$booking->booking_status] }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.payment_status') }}</label>
                    @if (isset($paymentStatuses[$booking->payment_status]))
                        <p>{{ $paymentStatuses[$booking->payment_status] }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.vendor_purchase_status') }}</label>
                    @if (isset($vendorPurchaseStatuses[$booking->vendor_purchase_status]))
                        <p>{{ $vendorPurchaseStatuses[$booking->vendor_purchase_status] }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.hotel_id') }}</label>
                    @if ($booking->hotel)
                        <p>{{ $booking->hotel->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.customer_id') }}</label>
                    @if ($booking->customer)
                        <p>{{ $booking->customer->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.supplier_id') }}</label>
                    @if ($booking->supplier)
                        <p>{{ $booking->supplier->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.agency_id') }}</label>
                    @if ($booking->agency)
                        <p>{{ $booking->agency->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.sale_id') }}</label>
                    @if ($booking->sale)
                        <p>{{ $booking->sale->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.checkin_date') }}</label>
                    <p>{{ $checkinDate }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.checkout_date') }}</label>
                    <p>{{ $checkoutDate }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.hotel_confirm_code') }}</label>
                    @if (!empty($booking->hotel_confirm_code))
                        <p>{{ $booking->hotel_confirm_code }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.flight_code') }}</label>
                    @if (!empty($booking->flight_code))
                        <p>{{ $booking->flight_code }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.campaign_id') }}</label>
                    @if ($booking->campaign)
                        <p>{{ $booking->campaign->name }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.is_adjust_surcharge') }}</label>
                    @if ($booking->is_adjust_surcharge === 1)
                        <p>{{ trans('booking::bookings.form.yes_value') }}</p>
                    @else
                        <p>{{ trans('booking::bookings.form.no_value') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.is_adjust_price') }}</label>
                    @if ($booking->is_adjust_price === 1)
                        <p>{{ trans('booking::bookings.form.yes_value') }}</p>
                    @else
                        <p>{{ trans('booking::bookings.form.no_value') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="room-list-container">
            <div class="row">
                <div class="col-md-12">
                    <h4>{{  trans('booking::bookings.form.room') }}</h4>
                </div>
            </div>

            @php
                $rooms = $booking->rooms()->get();
                $firstRoom = $rooms->first();
                $firstRoomStartDate = \DateTime::createFromFormat('Y-m-d', $firstRoom->pivot->start_date)->format('d/m/Y');
                $firstRoomEndDate = \DateTime::createFromFormat('Y-m-d', $firstRoom->pivot->end_date)->format('d/m/Y');
            @endphp

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.room_id') }}</label>
                        <p>{{ $firstRoom->name }}</p>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.quantity') }}</label>
                        <p>{{ $firstRoom->pivot->quantity }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.start_date') }}</label>
                        <p>{{ $firstRoomStartDate }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.end_date') }}</label>
                        <p>{{ $firstRoomEndDate }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.buy_price') }}</label>
                        <p>{{ number_format($firstRoom->pivot->buy_price,2,".",",") }}</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.sell_price') }}</label>
                        <p>{{ number_format($firstRoom->pivot->sell_price,2,".",",") }}</p>
                    </div>
                </div>
            </div>

            @if(count($rooms) > 1 && empty(old('room_id')))
                @foreach ($rooms as $key => $room)
                    @php
                        $roomStartDate = \DateTime::createFromFormat('Y-m-d', $room->pivot->start_date)->format('d/m/Y');
                        $roomEndDate = \DateTime::createFromFormat('Y-m-d', $room->pivot->end_date)->format('d/m/Y');
                    @endphp
                    @if ($key !== 0)
                        <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $room->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <p>{{ $room->pivot->quantity }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $roomStartDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $roomEndDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($room->pivot->buy_price,2,".",",") }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($room->pivot->sell_price,2,".",",") }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>

        @php
            $services = $booking->services()->get();
        @endphp
        <div class="service-list-container">
            <div class="row">
                <div class="col-md-12">
                    <h4>{{  trans('booking::bookings.form.service') }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_id') }}</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_quantity') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_start_date') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_end_date') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_buy_price') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.service_sell_price') }}</label>
                    </div>
                </div>
            </div>

            @if(count($services) > 0 && empty(old('service_id')))
                @foreach ($services as $key => $service)
                    @php
                        $serviceStartDate = \DateTime::createFromFormat('Y-m-d', $service->pivot->start_date)->format('d/m/Y');
                        $serviceEndDate = \DateTime::createFromFormat('Y-m-d', $service->pivot->end_date)->format('d/m/Y');
                    @endphp
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $service->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <p>{{ $service->pivot->quantity }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $serviceStartDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $serviceEndDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($service->pivot->buy_price,2,".",",") }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($service->pivot->sell_price,2,".",",") }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @php
            $surcharges = $booking->surcharges()->get();
        @endphp
        <div class="surcharge-list-container">
            <div class="row">
                <div class="col-md-12">
                    <h4>{{  trans('booking::bookings.form.surcharge') }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_id') }}</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_quantity') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_start_date') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_end_date') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_buy_price') }}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.surcharge_sell_price') }}</label>
                    </div>
                </div>
            </div>
            @if(count($surcharges) > 0 && empty(old('surcharge_id')))
                @foreach ($surcharges as $key => $surcharge)
                    @php
                        $surchargeStartDate = \DateTime::createFromFormat('Y-m-d', $surcharge->pivot->start_date)->format('d/m/Y');
                        $surchargeEndDate = \DateTime::createFromFormat('Y-m-d', $surcharge->pivot->end_date)->format('d/m/Y');
                    @endphp
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $surcharge->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <p>{{ $surcharge->pivot->quantity }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $surchargeStartDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ $surchargeEndDate }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($surcharge->pivot->buy_price,2,".",",") }}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p>{{ number_format($surcharge->pivot->sell_price,2,".",",") }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="total-list-container">
            <div class="row">
                <div class="col-md-12">
                    <h4>{{  trans('booking::bookings.form.total') }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.total_price') }}</label>
                        <p>{{ number_format($booking->total_price,2,".",",") }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.total_buy_price') }}</label>
                        <p>{{ number_format($booking->total_buy_price,2,".",",") }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.total_sell_price') }}</label>
                        <p>{{ number_format($booking->total_sell_price,2,".",",") }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('booking::bookings.form.total_profit') }}</label>
                        <p>{{ number_format($booking->total_profit,2,".",",") }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('booking::bookings.form.note') }}</label>
                    @if (!empty($booking->note))
                        <p>{{ $booking->note }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
