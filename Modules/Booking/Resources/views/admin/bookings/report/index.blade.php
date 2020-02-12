@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('booking::bookings.title.report booking') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.booking.booking.index') }}">{{ trans('booking::bookings.title.bookings') }}</a></li>
        <li class="active">{{ trans('booking::bookings.title.report booking') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.booking.booking.report.create'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ ($errors->has('start_date')) ? ' has-error' : '' }}">
                                    {!! Form::label('start_date', trans('booking::bookings.form.start_date'), array('class' => 'required')) !!}
                                    {!! Form::text('start_date', old('start_date'), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.start_date')]) !!}
                                    {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ ($errors->has('end_date')) ? ' has-error' : '' }}">
                                    {!! Form::label('end_date', trans('booking::bookings.form.end_date'), array('class' => 'required')) !!}
                                    {!! Form::text('end_date', old('end_date'), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.end_date')]) !!}
                                    {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('report_type') ? 'has-error' : '' }}">
                                    {!! Form::label('report_type', trans('booking::bookings.form.report_type'), array('class' => 'required')) !!}
                                    {!! Form::select('report_type', $reportType, old('report_type') , ['class' => 'selectize-single']) !!}
                                    {!! $errors->first('report_type', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="submit_button" value="Create Report">
                        <input type="submit" class="btn btn-primary btn-flat pull-right" name="submit_button" value="Export Excel">
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}

    @if (isset($reports))
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if (count($reports) > 0)
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <tr>
                                <th></th>
                                <th>{{ trans('booking::bookings.table.total_amount') }}</th>
                                <th>{{ trans('booking::bookings.table.total_profit') }}</th>
                                <th>{{ trans('booking::bookings.table.total_night') }}</th>
                            </tr>
                            @foreach($reports as $report)
                                <tr>
                                    <td>
                                        {{ $report['name'] }}
                                    </td>
                                    <td>
                                        {{ number_format($report['total_amount'],2,".",",") }}
                                    </td>
                                    <td>
                                        {{ number_format($report['total_profit'],2,".",",") }}
                                    </td>
                                    <td>
                                        {{ $report['total_night'] }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="highlighted-row">
                                <td>
                                    {{ trans('booking::bookings.table.total') }}
                                </td>
                                <td>
                                    {{ number_format($totalRow['total_amount'],2,".",",") }}
                                </td>
                                <td>
                                    {{ number_format($totalRow['total_profit'],2,".",",") }}
                                </td>
                                <td>
                                    {{ $totalRow['total_night'] }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @else
                    {{ trans('booking::bookings.messages.no_record_for_report') }}
                @endif
            </div>
        </div>
    @endif
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
                    { key: 'b', route: "<?= route('admin.booking.booking.index') ?>" }
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

@include('core::partials.ajax-loading')
