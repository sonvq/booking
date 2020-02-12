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
                    <th>{{ trans('room::rooms.table.name') }}</th>
                    <th>{{ trans('room::rooms.table.description') }}</th>
                    <th>{{ trans('room::rooms.table.price') }}</th>
                    <th>{{ trans('room::rooms.table.amount') }}</th>
                    <th>{{ trans('room::rooms.table.change') }}</th>
                    <th>{{ trans('room::rooms.table.type') }}</th>
                    <th>{{ trans('core::core.table.created at') }}</th>
                    <th>{{ trans('core::core.table.updated at') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                <tr>
                    <td>
                        {{ $room->id }}
                    </td>
                    <td>
                        <a href="{{ route('admin.room.room.edit', [$room->id]) }}">
                            {{ $room->name }}
                        </a>
                    </td>
                    <td>
                        {{ str_limit($room->description, $limit = 80, $end = '...') }}
                    </td>
                    <td>
                        {{ number_format($room->price,2,".",",") }}
                    </td>
                    <td>
                        @if (!empty($room->amount))
                            {{ number_format($room->amount,2,".",",") }}
                        @endif
                    </td>
                    <td>
                        @if (!empty($room->change) && isset($changes[$room->change]))
                            {{ $changes[$room->change] }}
                        @endif
                    </td>
                    <td>
                        @if (!empty($room->type) && isset($types[$room->type]))
                            {{ $types[$room->type] }}
                        @endif
                    </td>
                    <td>
                        {{ $room->created_at }}
                    </td>
                    <td>
                        {{ $room->updated_at }}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.room.room.edit', [$room->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.room.room.destroy', [$room->id]) }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>{{ trans('core::core.table.id') }}</th>
                    <th>{{ trans('room::rooms.table.name') }}</th>
                    <th>{{ trans('room::rooms.table.description') }}</th>
                    <th>{{ trans('room::rooms.table.price') }}</th>
                    <th>{{ trans('room::rooms.table.amount') }}</th>
                    <th>{{ trans('room::rooms.table.change') }}</th>
                    <th>{{ trans('room::rooms.table.type') }}</th>
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