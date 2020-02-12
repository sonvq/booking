@if (!empty($reports))
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (count($reports) > 0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <tr>
                            <th></th>
                            <th>{{ trans('booking::bookings.table.total_amount') }}</th>
                            <th>{{ trans('booking::bookings.table.total_profit') }}</th>
                            <th>{{ trans('booking::bookings.table.total_night') }}</th>
                        </tr>
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    {{ $report['name'] }}
                                </td>
                                <td>
                                    {{ number_format($report['total_amount'],2,".",",") }}
                                </td>
                                <td>
                                    {{ number_format($report['total_profit'],2,".",",") }}
                                </td>
                                <td>
                                    {{ $report['total_night'] }}
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
                            <td>
                                <b>{{ number_format($totalRow['total_profit'],2,".",",") }}</b>
                            </td>
                            <td>
                                <b>{{ $totalRow['total_night'] }}</b>
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