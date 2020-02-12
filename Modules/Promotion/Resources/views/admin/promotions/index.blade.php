@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('promotion::promotions.title.promotions') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('promotion::promotions.title.promotions') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.promotion.promotion.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('promotion::promotions.button.create promotion') }}
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
                                    <th>{{ trans('promotion::promotions.table.name') }}</th>
                                    <th>{{ trans('promotion::promotions.table.description') }}</th>
                                    <th>{{ trans('promotion::promotions.table.amount') }}</th>
                                    <th>{{ trans('promotion::promotions.table.change') }}</th>
                                    <th>{{ trans('promotion::promotions.table.type') }}</th>
                                    <th>{{ trans('core::core.table.created at') }}</th>
                                    <th>{{ trans('core::core.table.updated at') }}</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($promotions)): ?>
                            <?php foreach ($promotions as $promotion): ?>
                            <tr>
                                <td>
                                    {{ $promotion->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.promotion.promotion.edit', [$promotion->id]) }}">
                                        {{ $promotion->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ str_limit($promotion->description, $limit = 80, $end = '...') }}
                                </td>
                                <td>
                                    @if (!empty($promotion->amount))
                                        {{ number_format($promotion->amount,2,".",",") }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($changes[$promotion->change]))
                                        {{ $changes[$promotion->change] }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($types[$promotion->type]))
                                        {{ $types[$promotion->type] }}
                                    @endif
                                </td>
                                <td>
                                    {{ $promotion->created_at }}
                                </td>
                                <td>
                                    {{ $promotion->updated_at }}
                                </td>
                                <td>
                                    <div class="btn-group" style="min-width: 78px">
                                        <a href="{{ route('admin.promotion.promotion.edit', [$promotion->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.promotion.promotion.destroy', [$promotion->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ trans('core::core.table.id') }}</th>
                                    <th>{{ trans('promotion::promotions.table.name') }}</th>
                                    <th>{{ trans('promotion::promotions.table.description') }}</th>
                                    <th>{{ trans('promotion::promotions.table.amount') }}</th>
                                    <th>{{ trans('promotion::promotions.table.change') }}</th>
                                    <th>{{ trans('promotion::promotions.table.type') }}</th>
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
        <dd>{{ trans('promotion::promotions.title.create promotion') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.promotion.promotion.create') ?>" }
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
