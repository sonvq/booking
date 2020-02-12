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
                        @if(isset($type[$bill->type]))
                            {{ $type[$bill->type] }}
                        @endif
                    </td>
                    <td>
                        {{ number_format($bill->amount,2,".",",") }}
                    </td>
                    <td>
                        @if(isset($paymentType[$bill->payment_type]))
                            {{ $paymentType[$bill->payment_type] }}
                        @endif
                    </td>
                    <td>
                        @if(isset($status[$bill->status]))
                            {{ $status[$bill->status] }}
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
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>
