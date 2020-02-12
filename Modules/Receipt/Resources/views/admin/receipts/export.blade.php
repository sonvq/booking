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
            @if(isset($type[$receipt->type]))
                {{ $type[$receipt->type] }}
            @endif
        </td>
        <td>
            {{ number_format($receipt->amount,2,".",",") }}
        </td>
        <td>
            @if(isset($paymentType[$receipt->payment_type]))
                {{ $paymentType[$receipt->payment_type] }}
            @endif
        </td>
        <td>
            @if(isset($status[$receipt->status]))
                {{ $status[$receipt->status] }}
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
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>