@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('receipt::receipts.title.receipts') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('receipt::receipts.title.receipts') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-10">
                    @include('receipt::admin.receipts.partials.filter-fields')
                </div>
                <div class="col-xs-2">
                    <div class="btn-group pull-right">
                        <a href="{{ route('admin.receipt.receipt.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                            <i class="fa fa-pencil"></i> {{ trans('receipt::receipts.button.create receipt') }}
                        </a>
                    </div>
                </div>
            </div>
            @include('receipt::admin.receipts.partials.index-fields', ['origin_url' => 'receipt'])
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
        <dd>{{ trans('receipt::receipts.title.create receipt') }}</dd>
    </dl>
@stop

@push('js-stack')
    @include('receipt::admin.receipts.partials.index-javascript')
@endpush
