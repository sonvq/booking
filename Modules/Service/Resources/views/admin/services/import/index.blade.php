@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('service::services.title.import service') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.service.service.index') }}">{{ trans('service::services.title.services') }}</a></li>
        <li class="active">{{ trans('service::services.title.import service') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.service.service.import.create'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('import_file') ? ' has-error' : '' }}">
                                    <p>{{ trans('service::services.title.import hint text') }}</p>
                                    {!! Form::label('import_file', trans('service::services.form.import_file'), array('class' => 'required')) !!}
                                    {{  Form::file('import_file') }}
                                    {!! $errors->first('import_file', '<span class="help-block">:message</span>') !!}
                                    {{ csrf_field() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                                    {!! Form::label('hotel_id', trans('service::services.form.hotel_id'), array('class' => 'required')) !!}
                                    {!! Form::select('hotel_id[]', $hotels, old('hotel_id[]') , ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                                    {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('service::services.button.import') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.service.service.index')}}">
                            <i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}
                        </a>
                    </div>
                </div>

            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
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
                    { key: 'b', route: "<?= route('admin.service.service.index') ?>" }
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
