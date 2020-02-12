@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('booking::bookings.title.edit booking') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.booking.booking.index') }}">{{ trans('booking::bookings.title.bookings') }}</a></li>
        <li class="active">{{ trans('booking::bookings.title.edit booking') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('booking::bookings.tabs.booking') }}</a></li>
                    <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('booking::bookings.tabs.detail') }}</a></li>
                    <li class=""><a href="#tab_3-3" data-toggle="tab">{{ trans('booking::bookings.tabs.receipt') }}</a></li>
                    <li class=""><a href="#tab_4-4" data-toggle="tab">{{ trans('booking::bookings.tabs.bill') }}</a></li>
                </ul>
                <div class="tab-content">
                    @include('booking::admin.bookings.partials.booking')
                    @include('booking::admin.bookings.partials.detail')
                    @include('booking::admin.bookings.partials.receipt')
                    @include('booking::admin.bookings.partials.bill')
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.booking.booking.index') ?>" }
                ]
            });

            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('.data-table').dataTable({
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
        });
    </script>
@endpush

@include('core::partials.ajax-loading')
