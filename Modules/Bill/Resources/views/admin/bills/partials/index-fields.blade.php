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
                    <th>{{ trans('bill::bills.table.unique_number') }}</th>
                    <th>{{ trans('bill::bills.table.booking_number') }}</th>
                    <th>{{ trans('bill::bills.table.type') }}</th>
                    <th>{{ trans('bill::bills.table.amount') }}</th>
                    <th>{{ trans('bill::bills.table.payment_type') }}</th>
                    <th>{{ trans('bill::bills.table.status') }}</th>
                    <th>{{ trans('bill::bills.table.start_date') }}</th>
                    <th>{{ trans('bill::bills.table.author_id') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.type') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.payment_type') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.status') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($bills)): ?>
                <?php foreach ($bills as $bill): ?>
                <tr>
                    <td>
                        <a href="{{ route('admin.bill.bill.edit', [$bill->id]) }}">
                            {{ $bill->id }}
                        </a>
                    </td>
                    <td>
                        {{ $bill->unique_number }}
                    </td>
                    <td>
                        @if(!empty($bill->booking))
                            {{ $bill->booking->booking_number }}
                        @endif
                    </td>
                    <td>
                        @if(isset($billType[$bill->type]))
                            {{ $billType[$bill->type] }}
                        @endif
                    </td>
                    <td>
                        {{ number_format($bill->amount,2,".",",") }}
                    </td>
                    <td>
                        @if(isset($billPaymentType[$bill->payment_type]))
                            {{ $billPaymentType[$bill->payment_type] }}
                        @endif
                    </td>
                    <td>
                        @if(isset($billStatus[$bill->status]))
                            {{ $billStatus[$bill->status] }}
                        @endif
                    </td>
                    @php
                        $startDate = \DateTime::createFromFormat('Y-m-d', $bill->start_date)->format('d/m/Y');
                    @endphp
                    <td>
                        {{ $startDate }}
                    </td>
                    <td>
                        @if($bill->author)
                            {{ $bill->author->name }}
                        @endif
                    </td>
                    <td class="hidden">
                        {{$bill->type}}
                    </td>
                    <td class="hidden">
                        {{$bill->payment_type}}
                    </td>
                    <td class="hidden">
                        {{$bill->status}}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.bill.bill.edit', [$bill->id, 'origin_url' => $origin_url]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.bill.bill.destroy', [$bill->id]) }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>{{ trans('core::core.table.id') }}</th>
                    <th>{{ trans('bill::bills.table.unique_number') }}</th>
                    <th>{{ trans('bill::bills.table.booking_number') }}</th>
                    <th>{{ trans('bill::bills.table.type') }}</th>
                    <th>{{ trans('bill::bills.table.amount') }}</th>
                    <th>{{ trans('bill::bills.table.payment_type') }}</th>
                    <th>{{ trans('bill::bills.table.status') }}</th>
                    <th>{{ trans('bill::bills.table.start_date') }}</th>
                    <th>{{ trans('bill::bills.table.author_id') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.type') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.payment_type') }}</th>
                    <th class="hidden">{{ trans('bill::bills.table.status') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </tfoot>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>
