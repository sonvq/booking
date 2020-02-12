@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('booking::bookings.title.bookings') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('booking::bookings.title.bookings') }}</li>
    </ol>
@stop

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-10">
                    <div class="btn-group pull-left form-inline" id="table_filter_container">
                        <form method="get">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.booking_number') }}" id="booking_number_filter" name="booking_number_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.campaign_id') }}" id="campaign_id_filter" name="campaign_id_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.hotel_id') }}" id="hotel_id_filter" name="hotel_id_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.agency_id') }}" id="agency_id_filter" name="agency_id_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.supplier_id') }}" id="supplier_id_filter" name="supplier_id_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.customer_id') }}" id="customer_id_filter" name="customer_id_filter">
                            <select class="input-filter form-control input-sm" id="date_filter" name="date_filter">
                                <option value="">{{ trans('booking::bookings.table.date_empty_option_filter') }}</option>
                                <option value="checkin_date">{{ trans('booking::bookings.table.checkin') }}</option>
                                <option value="checkout_date">{{ trans('booking::bookings.table.checkout') }}</option>
                                <option value="cod">{{ trans('booking::bookings.table.cod') }}</option>
                            </select>
                            <input class="input-filter form-control input-sm datepicker" type="text" placeholder="{{ trans('booking::bookings.table.start_date') }}" id="start_date_filter" name="start_date_filter">
                            <input class="input-filter form-control input-sm datepicker" type="text" placeholder="{{ trans('booking::bookings.table.end_date') }}" id="end_date_filter" name="end_date_filter">
                            <select class="input-filter form-control input-sm" id="booking_status_filter" name="booking_status_filter">
                                <option value="">{{ trans('booking::bookings.table.booking_status_empty_option') }}</option>
                                @foreach ($bookingStatuses as $key => $bookingStatus)
                                    <option value="{{ $key }}">{{ $bookingStatus }}</option>
                                @endforeach
                            </select>
                            <select class="input-filter form-control input-sm" id="payment_status_filter" name="payment_status_filter">
                                <option value="">{{ trans('booking::bookings.table.payment_status_empty_option') }}</option>
                                @foreach ($paymentStatuses as $key => $paymentStatus)
                                    <option value="{{ $key }}">{{ $paymentStatus }}</option>
                                @endforeach
                            </select>
                            <select class="input-filter form-control input-sm" id="vendor_purchase_status_filter" name="vendor_purchase_status_filter">
                                <option value="">{{ trans('booking::bookings.table.vendor_purchase_status_empty_option') }}</option>
                                @foreach ($vendorPurchaseStatuses as $key => $vendorPurchaseStatus)
                                    <option value="{{ $key }}">{{ $vendorPurchaseStatus }}</option>
                                @endforeach
                            </select>
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.hotel_confirm_code') }}" id="hotel_confirm_code_filter" name="hotel_confirm_code_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.flight_code') }}" id="flight_code_filter" name="flight_code_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.author_id') }}" id="author_id_filter" name="author_id_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('booking::bookings.table.sale_id') }}" id="sale_id_filter" name="sale_id_filter">
                            <select class="input-filter form-control input-sm" id="booking_type_filter" name="booking_type_filter">
                                <option value="">{{ trans('booking::bookings.table.booking_type_empty_option') }}</option>
                                <option value="booking_urgent">{{ trans('booking::bookings.table.booking_type_urgent') }}</option>
                                <option value="booking_in_due">{{ trans('booking::bookings.table.booking_type_in_due') }}</option>
                                <option value="booking_completed">{{ trans('booking::bookings.table.booking_type_completed') }}</option>
                                <option value="booking_cancelled">{{ trans('booking::bookings.table.booking_type_cancelled') }}</option>
                                <option value="booking_in_dept">{{ trans('booking::bookings.table.booking_type_in_dept') }}</option>
                                <option value="booking_customer_balance">{{ trans('booking::bookings.table.booking_type_customer_balance') }}</option>
                                <option value="booking_hotel_balance">{{ trans('booking::bookings.table.booking_type_hotel_balance') }}</option>
                            </select>

                            <button type="button" class="input-sm input-filter form-control btn-primary btn-flat" id="reset_filter">
                                {{ trans('booking::bookings.table.reset_filter') }}
                            </button>

                            <button type="submit" class="input-sm input-filter form-control btn-info btn-flat">
                                {{ trans('booking::bookings.table.submit_export') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="btn-group pull-right">
                        <a href="{{ route('admin.booking.booking.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                            <i class="fa fa-pencil"></i> {{ trans('booking::bookings.button.create booking') }}
                        </a>
                    </div>
                </div>
            </div>
            @include('booking::admin.bookings.partials.index-fields')
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('booking::bookings.title.create booking') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@stop

@include('booking::admin.bookings.partials.index-javascript')
