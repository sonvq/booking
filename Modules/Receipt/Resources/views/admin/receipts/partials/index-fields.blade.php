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
                    <th>{{ trans('receipt::receipts.table.unique_number') }}</th>
                    <th>{{ trans('receipt::receipts.table.booking_number') }}</th>
                    <th>{{ trans('receipt::receipts.table.type') }}</th>
                    <th>{{ trans('receipt::receipts.table.amount') }}</th>
                    <th>{{ trans('receipt::receipts.table.payment_type') }}</th>
                    <th>{{ trans('receipt::receipts.table.status') }}</th>
                    <th>{{ trans('receipt::receipts.table.start_date') }}</th>
                    <th>{{ trans('receipt::receipts.table.author_id') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.type') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.payment_type') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.status') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($receipts)): ?>
                <?php foreach ($receipts as $receipt): ?>
                <tr>
                    <td>
                        <a href="{{ route('admin.receipt.receipt.edit', [$receipt->id]) }}">
                            {{ $receipt->id }}
                        </a>
                    </td>
                    <td>
                        {{ $receipt->unique_number }}
                    </td>
                    <td>
                        @if(!empty($receipt->booking))
                            {{ $receipt->booking->booking_number }}
                        @endif
                    </td>
                    <td>
                        @if(isset($receiptType[$receipt->type]))
                            {{ $receiptType[$receipt->type] }}
                        @endif
                    </td>
                    <td>
                        {{ number_format($receipt->amount,2,".",",") }}
                    </td>
                    <td>
                        @if(isset($receiptPaymentType[$receipt->payment_type]))
                            {{ $receiptPaymentType[$receipt->payment_type] }}
                        @endif
                    </td>
                    <td>
                        @if(isset($receiptStatus[$receipt->status]))
                            {{ $receiptStatus[$receipt->status] }}
                        @endif
                    </td>
                    @php
                        $startDate = \DateTime::createFromFormat('Y-m-d', $receipt->start_date)->format('d/m/Y');
                    @endphp
                    <td>
                        {{ $startDate }}
                    </td>
                    <td>
                        @if($receipt->author)
                            {{ $receipt->author->name }}
                        @endif
                    </td>
                    <td class="hidden">
                        {{$receipt->type}}
                    </td>
                    <td class="hidden">
                        {{$receipt->payment_type}}
                    </td>
                    <td class="hidden">
                        {{$receipt->status}}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.receipt.receipt.edit', [$receipt->id, 'origin_url' => $origin_url]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.receipt.receipt.destroy', [$receipt->id]) }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>{{ trans('core::core.table.id') }}</th>
                    <th>{{ trans('receipt::receipts.table.unique_number') }}</th>
                    <th>{{ trans('receipt::receipts.table.booking_number') }}</th>
                    <th>{{ trans('receipt::receipts.table.type') }}</th>
                    <th>{{ trans('receipt::receipts.table.amount') }}</th>
                    <th>{{ trans('receipt::receipts.table.payment_type') }}</th>
                    <th>{{ trans('receipt::receipts.table.status') }}</th>
                    <th>{{ trans('receipt::receipts.table.start_date') }}</th>
                    <th>{{ trans('receipt::receipts.table.author_id') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.type') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.payment_type') }}</th>
                    <th class="hidden">{{ trans('receipt::receipts.table.status') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </tfoot>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>
