<div class="btn-group pull-left form-inline table_filter_container">
    <form method="get">
        <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('receipt::receipts.table.unique_number') }}" id="unique_number_filter" name="unique_number_filter">
        <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('receipt::receipts.table.booking_number') }}" id="booking_number_filter" name="booking_number_filter">
        <select class="input-filter form-control input-sm" id="type_filter" name="type_filter">
            @foreach ($receiptType as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('receipt::receipts.table.amount') }}" id="amount_filter" name="amount_filter">
        <select class="input-filter form-control input-sm" id="payment_type_filter" name="payment_type_filter">
            @foreach ($receiptPaymentType as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <select class="input-filter form-control input-sm" id="status_filter" name="status_filter">
            @foreach ($receiptStatus as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <input class="input-filter form-control input-sm datepicker" autocomplete="off" type="text" placeholder="{{ trans('receipt::receipts.table.start_date_filter') }}" id="start_date_filter" name="start_date_filter">
        <input class="input-filter form-control input-sm datepicker" autocomplete="off" type="text" placeholder="{{ trans('receipt::receipts.table.end_date_filter') }}" id="end_date_filter" name="end_date_filter">
        <input class="input-filter form-control input-sm" type="text" placeholder="{{ trans('receipt::receipts.table.author_id') }}" id="author_id_filter" name="author_id_filter">
        <button type="button" class="input-sm input-filter form-control btn-primary btn-flat reset_filter">
            {{ trans('receipt::receipts.table.reset_filter') }}
        </button>

        <button type="submit" class="input-sm input-filter form-control btn-info btn-flat">
            {{ trans('receipt::receipts.table.submit_export') }}
        </button>
    </form>
</div>