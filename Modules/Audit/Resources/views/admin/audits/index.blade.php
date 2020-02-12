@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('audit::audits.title.audits') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('audit::audits.title.audits') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('audit::audits.table.id') }}</th>
                                <th>{{ trans('audit::audits.table.author') }}</th>
                                <th>{{ trans('audit::audits.table.action') }}</th>
                                <th>{{ trans('audit::audits.table.entity') }}</th>
                                <th>{{ trans('audit::audits.table.entity id') }}</th>
                                <th>{{ trans('audit::audits.table.old value') }}</th>
                                <th>{{ trans('audit::audits.table.new value') }}</th>
                                <th>{{ trans('audit::audits.table.created at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($audits)): ?>
                            <?php foreach ($audits as $audit): ?>
                            <tr>
                                <td>
                                    {{  $audit->id }}
                                </td>
                                <td>
                                    @if ($audit->author)
                                        {{  $audit->author->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ trans("audit::audits.table.$audit->event") }}
                                </td>
                                <td>
                                    {{ trans("audit::audits.table.$audit->auditable_type") }}
                                </td>
                                <td>
                                    {{ $audit->auditable_id }}
                                </td>
                                @php
                                    $oldValue = json_decode($audit->old_values, true);
                                    $newValue = json_decode($audit->new_values, true);
                                @endphp
                                <td width="500" class="danger">
                                    <ul>
                                    @foreach($oldValue as $name => $value)
                                        @if(empty($value))
                                            @php $value = 'n/a'; @endphp
                                        @endif
                                        @if(is_array($value))
                                            @if (isset($value['date']))
                                                @php $value = $value['date'] @endphp
                                            @endif
                                        @endif
                                        <li><span style="min-width: 170px; display: inline-block; padding-right: 20px;"><strong>{{$name}}</strong></span> <span style="color: red"><strong>{{ $value }}</strong></span></li>
                                    @endforeach
                                    </ul>
                                </td>
                                <td width="500" class="success">
                                    <ul>
                                    @foreach($newValue as $name => $value)
                                        @if(empty($value))
                                            @php $value = 'n/a'; @endphp
                                        @endif
                                        @if(is_array($value))
                                                @if (isset($value['date']))
                                                    @php $value = $value['date'] @endphp
                                                @endif
                                        @endif
                                        <li><span style="min-width: 170px; display: inline-block; padding-right: 20px;"><strong>{{$name}}</strong></span> <span style="color: green"><strong>{{ $value }}</strong></span></li>
                                    @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{ $audit->created_at }}
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('audit::audits.table.id') }}</th>
                                <th>{{ trans('audit::audits.table.author') }}</th>
                                <th>{{ trans('audit::audits.table.action') }}</th>
                                <th>{{ trans('audit::audits.table.entity') }}</th>
                                <th>{{ trans('audit::audits.table.entity id') }}</th>
                                <th>{{ trans('audit::audits.table.old value') }}</th>
                                <th>{{ trans('audit::audits.table.new value') }}</th>
                                <th>{{ trans('audit::audits.table.created at') }}</th>
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
        <dd>{{ trans('audit::audits.title.create audit') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.audit.audit.create') ?>" }
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
