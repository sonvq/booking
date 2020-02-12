@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('hotel::hotels.title.edit hotel') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.hotel.hotel.index') }}">{{ trans('hotel::hotels.title.hotels') }}</a></li>
        <li class="active">{{ trans('hotel::hotels.title.edit hotel') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.hotel.hotel.update', $hotel->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('hotel::hotels.tabs.hotel') }}</a></li>
                    <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('hotel::hotels.tabs.room') }}</a></li>
                </ul>
                <div class="tab-content">
                    @include('hotel::admin.hotels.partials.edit-fields')
                    @include('hotel::admin.hotels.partials.room')
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
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
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.hotel.hotel.index') ?>" }
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
