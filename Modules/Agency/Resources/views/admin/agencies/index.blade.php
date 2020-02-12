@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('agency::agencies.title.agencies') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('agency::agencies.title.agencies') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.agency.agency.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('agency::agencies.button.create agency') }}
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
                                <th>{{ trans('agency::agencies.table.name') }}</th>
                                <th>{{ trans('agency::agencies.table.email') }}</th>
                                <th>{{ trans('agency::agencies.table.telephone') }}</th>
                                <th>{{ trans('agency::agencies.table.description') }}</th>
                                <th>{{ trans('agency::agencies.table.amount') }}</th>
                                <th>{{ trans('agency::agencies.table.change') }}</th>
                                <th>{{ trans('agency::agencies.table.type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.updated at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($agencies))
                                @foreach ($agencies as $agency)
                                    <tr>
                                        <td>
                                            {{ $agency->id }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agency.agency.edit', [$agency->id]) }}">
                                                {{ $agency->name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $agency->email }}
                                        </td>
                                        <td>
                                            {{ $agency->telephone }}
                                        </td>
                                        <td>
                                            {{ str_limit($agency->description, $limit = 80, $end = '...') }}
                                        </td>
                                        <td>
                                            @if (!empty($agency->amount))
                                                {{ number_format($agency->amount,2,".",",") }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($changes[$agency->change]))
                                                {{ $changes[$agency->change] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($types[$agency->type]))
                                                {{ $types[$agency->type] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $agency->created_at }}
                                        </td>
                                        <td>
                                            {{ $agency->updated_at }}
                                        </td>
                                        <td>
                                            <div class="btn-group" style="min-width: 78px">
                                                <a href="{{ route('admin.agency.agency.edit', [$agency->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.agency.agency.destroy', [$agency->id]) }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('core::core.table.id') }}</th>
                                <th>{{ trans('agency::agencies.table.name') }}</th>
                                <th>{{ trans('agency::agencies.table.email') }}</th>
                                <th>{{ trans('agency::agencies.table.telephone') }}</th>
                                <th>{{ trans('agency::agencies.table.description') }}</th>
                                <th>{{ trans('agency::agencies.table.amount') }}</th>
                                <th>{{ trans('agency::agencies.table.change') }}</th>
                                <th>{{ trans('agency::agencies.table.type') }}</th>
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
        <dd>{{ trans('agency::agencies.title.create agency') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.agency.agency.create') ?>" }
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
