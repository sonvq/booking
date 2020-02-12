@if (!empty($reports))
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (count($reports) > 0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    {{ $report['name'] }}
                                </td>
                                <td>
                                    {{ number_format($report['amount'],2,".",",") }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="highlighted-row">
                            <td>
                                <b>{{ trans('booking::bookings.table.total') }}</b>
                            </td>
                            <td>
                                <b>{{ number_format($totalRow['total_amount'],2,".",",") }}</b>
                            </td>
                        </tr>
                    </table>
                </div>
            @else
                {{ trans('booking::bookings.messages.no_record_for_report') }}
            @endif
        </div>
    </div>
@endif