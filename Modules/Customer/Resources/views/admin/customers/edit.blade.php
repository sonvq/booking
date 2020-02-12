@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('customer::customers.title.edit customer') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.customer.customer.index') }}">{{ trans('customer::customers.title.customers') }}</a></li>
        <li class="active">{{ trans('customer::customers.title.edit customer') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('customer::customers.tabs.edit') }}</a></li>
                    <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('customer::customers.tabs.booking') }}</a></li>
                </ul>
                <div class="tab-content">
                    @include('customer::admin.customers.partials.edit-fields')
                    @include('customer::admin.customers.partials.booking')
                </div>

            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>

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
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.customer.customer.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
