@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('customer::customers.title.customers') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('customer::customers.title.customers') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-10">
                    <div class="btn-group pull-left form-inline" id="table_filter_container">
                        <form method="get">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.name') }}" id="name_filter" name="name_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.email') }}" id="email_filter" name="email_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.telephone') }}" id="telephone_filter" name="telephone_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.identity') }}" id="identity_filter" name="identity_filter">
                            <select class="input-filter form-control input-sm" id="date_filter" name="date_filter">
                                <option value="">{{ trans('customer::customers.table.date_empty_option_filter') }}</option>
                                <option value="birthday">{{ trans('customer::customers.table.birthday') }}</option>
                                <option value="appointment">{{ trans('customer::customers.table.appointment') }}</option>
                            </select>
                            <input class="input-filter form-control input-sm datepicker" autocomplete="off" type="text" placeholder="{{ trans('customer::customers.table.start_date') }}" id="start_date_filter" name="start_date_filter">
                            <input class="input-filter form-control input-sm datepicker" autocomplete="off" type="text" placeholder="{{ trans('customer::customers.table.end_date') }}" id="end_date_filter" name="end_date_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.note') }}" id="note_filter" name="note_filter">
                            <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('customer::customers.table.author_id') }}" id="author_id_filter" name="author_id_filter">

                            <button type="button" class="input-sm input-filter form-control btn-primary btn-flat" id="reset_filter">
                                {{ trans('customer::customers.table.reset_filter') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                        <a href="{{ route('admin.customer.customer.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                            <i class="fa fa-pencil"></i> {{ trans('customer::customers.button.create customer') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('core::core.table.id') }}</th>
                                <th>{{ trans('customer::customers.table.name') }}</th>
                                <th>{{ trans('customer::customers.table.email') }}</th>
                                <th>{{ trans('customer::customers.table.telephone') }}</th>
                                <th>{{ trans('customer::customers.table.identity') }}</th>
                                <th>{{ trans('customer::customers.table.birthday') }}</th>
                                <th>{{ trans('customer::customers.table.appointment') }}</th>
                                <th>{{ trans('customer::customers.table.note') }}</th>
                                <th>{{ trans('customer::customers.table.author_id') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td>
                                    {{ $customer->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.customer.customer.edit', [$customer->id]) }}">
                                        {{ $customer->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $customer->email }}
                                </td>
                                <td>
                                    {{ $customer->telephone }}
                                </td>
                                <td>
                                    {{ $customer->identity }}
                                </td>
                                <td>
                                    @php
                                        $birthday = '';
                                        if (!empty($customer->birthday) && $customer->birthday !== '0000-00-00') :
                                            $birthday = \DateTime::createFromFormat('Y-m-d', $customer->birthday)->format('d/m/Y');
                                        endif
                                    @endphp
                                    {{ $birthday }}
                                </td>
                                <td>
                                    @php
                                        $appointment = '';
                                        if (!empty($customer->appointment) && $customer->appointment !== '0000-00-00') :
                                            $appointment = \DateTime::createFromFormat('Y-m-d', $customer->appointment)->format('d/m/Y');
                                        endif
                                    @endphp
                                    {{ $appointment }}
                                </td>
                                <td>
                                    {{ $customer->note }}
                                </td>
                                <td>
                                    @if($customer->author)
                                        {{ $customer->author->name }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" style="min-width: 78px">
                                        <a href="{{ route('admin.customer.customer.edit', [$customer->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.customer.customer.destroy', [$customer->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('core::core.table.id') }}</th>
                                <th>{{ trans('customer::customers.table.name') }}</th>
                                <th>{{ trans('customer::customers.table.email') }}</th>
                                <th>{{ trans('customer::customers.table.telephone') }}</th>
                                <th>{{ trans('customer::customers.table.identity') }}</th>
                                <th>{{ trans('customer::customers.table.birthday') }}</th>
                                <th>{{ trans('customer::customers.table.appointment') }}</th>
                                <th>{{ trans('customer::customers.table.note') }}</th>
                                <th>{{ trans('customer::customers.table.author_id') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
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
        <dd>{{ trans('customer::customers.title.create customer') }}</dd>
    </dl>
@stop

@include('customer::admin.customers.partials.index-javascript')
