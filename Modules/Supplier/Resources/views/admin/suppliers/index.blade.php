@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('supplier::suppliers.title.suppliers') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('supplier::suppliers.title.suppliers') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.supplier.supplier.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('supplier::suppliers.button.create supplier') }}
                    </a>
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
                                <th>{{ trans('supplier::suppliers.table.name') }}</th>
                                <th>{{ trans('supplier::suppliers.table.email') }}</th>
                                <th>{{ trans('supplier::suppliers.table.telephone') }}</th>
                                <th>{{ trans('supplier::suppliers.table.description') }}</th>
                                <th>{{ trans('supplier::suppliers.table.amount') }}</th>
                                <th>{{ trans('supplier::suppliers.table.change') }}</th>
                                <th>{{ trans('supplier::suppliers.table.type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.updated at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($suppliers)): ?>
                            <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td>
                                    {{ $supplier->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.supplier.supplier.edit', [$supplier->id]) }}">
                                        {{ $supplier->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $supplier->email }}
                                </td>
                                <td>
                                    {{ $supplier->telephone }}
                                </td>
                                <td>
                                    {{ str_limit($supplier->description, $limit = 80, $end = '...') }}
                                </td>
                                <td>
                                    @if (!empty($supplier->amount))
                                        {{ number_format($supplier->amount,2,".",",") }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($changes[$supplier->change]))
                                        {{ $changes[$supplier->change] }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($types[$supplier->type]))
                                        {{ $types[$supplier->type] }}
                                    @endif
                                </td>
                                <td>
                                    {{ $supplier->created_at }}
                                </td>
                                <td>
                                    {{ $supplier->updated_at }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.supplier.supplier.edit', [$supplier->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.supplier.supplier.destroy', [$supplier->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('core::core.table.id') }}</th>
                                <th>{{ trans('supplier::suppliers.table.name') }}</th>
                                <th>{{ trans('supplier::suppliers.table.email') }}</th>
                                <th>{{ trans('supplier::suppliers.table.telephone') }}</th>
                                <th>{{ trans('supplier::suppliers.table.description') }}</th>
                                <th>{{ trans('supplier::suppliers.table.amount') }}</th>
                                <th>{{ trans('supplier::suppliers.table.change') }}</th>
                                <th>{{ trans('supplier::suppliers.table.type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.updated at') }}</th>
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
        <dd>{{ trans('supplier::suppliers.title.create supplier') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.supplier.supplier.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
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
