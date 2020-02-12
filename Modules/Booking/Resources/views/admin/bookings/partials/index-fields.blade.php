<div class="box box-primary">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="data-table table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="3%">{{ trans('core::core.table.id') }}</th>
                    <th width="11%">{{ trans('booking::bookings.table.booking_number') }}</th>
                    <th width="11%">{{ trans('booking::bookings.table.campaign_id-hotel_id') }}</th>
                    <th width="7%">{{ trans('booking::bookings.table.agency_id-supplier_id') }}</th>
                    <th width="7%">{{ trans('booking::bookings.table.customer_id') }}</th>
                    <th width="8%">{{ trans('booking::bookings.table.checkin-checkout') }}</th>
                    <th width="17%">{{ trans('booking::bookings.table.status') }}</th>
                    <th width="10%">{{ trans('booking::bookings.table.hotel_confirm_code-flight_code') }}</th>
                    <th width="9%">{{ trans('booking::bookings.table.cod') }}</th>
                    <th width="8%">{{ trans('booking::bookings.table.sale_id-author_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.checkin') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.checkout') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.booking_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.payment_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.vendor_purchase_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.hotel_confirm_code') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.flight_code') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_sell_price') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_buy_price') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_receipt_amount') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_bill_amount') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.campaign_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.hotel_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.sale_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.author_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.agency_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.supplier_id') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                @php
                    $checkinDate = \DateTime::createFromFormat('Y-m-d', $booking->checkin_date)->format('d/m/Y');
                    $checkoutDate = \DateTime::createFromFormat('Y-m-d', $booking->checkout_date)->format('d/m/Y');
                    $codDate = \DateTime::createFromFormat('Y-m-d', $booking->cod)->format('d/m/Y');
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.booking.booking.edit', [$booking->id]) }}">
                            {{ $booking->id }}
                        </a>
                    </td>
                    <td>
                        {{ $booking->booking_number }}
                    </td>
                    <td>
                        @if($booking->campaign)
                            <p>{{ $booking->campaign->name }}</p>
                        @endif
                        @if($booking->hotel)
                            <p>{{ $booking->hotel->name }}</p>
                        @endif
                    </td>
                    <td>
                        @if($booking->agency)
                            <p>{{ $booking->agency->name }}</p>
                        @endif
                        @if($booking->supplier)
                            <p>{{ $booking->supplier->name }}</p>
                        @endif
                    </td>
                    <td>
                        @if($booking->customer)
                            {{ $booking->customer->name }}
                        @endif
                    </td>
                    <td>
                        <p>{{ $checkinDate  }} to</p>
                        <p>{{ $checkoutDate  }}</p>
                    </td>
                    <td>
                        {!! Form::select('booking_status', $bookingStatuses, $booking->booking_status, ['class' => 'selectize-single selectize-booking-status', 'data-booking-id' => $booking->id]) !!}
                        {!! Form::select('payment_status', $paymentStatuses, $booking->payment_status, ['class' => 'selectize-single selectize-payment-status', 'data-booking-id' => $booking->id]) !!}
                        {!! Form::select('vendor_purchase_status', $vendorPurchaseStatuses, $booking->vendor_purchase_status, ['class' => 'selectize-single selectize-vendor-purchase-status', 'data-booking-id' => $booking->id]) !!}
                    </td>
                    <td>
                        <p>{{ $booking->hotel_confirm_code }}</p>
                        <p>{{ $booking->flight_code }}</p>
                    </td>
                    <td>
                        {{ $codDate }}
                    </td>
                    <td>
                        @if($booking->author)
                            <p>{{ $booking->author->name }}</p>
                        @endif
                        @if($booking->sale)
                            <p>{{ $booking->sale->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        {{ $checkinDate  }}
                    </td>
                    <td class="hidden">
                        {{ $checkoutDate  }}
                    </td>
                    <td class="hidden" class="booking-status-cell">
                        {{ $booking->booking_status  }}
                    </td>
                    <td class="hidden" class="payment-status-cell">
                        {{ $booking->payment_status  }}
                    </td>
                    <td class="hidden" class="vendor-purchase-status-cell">
                        {{ $booking->vendor_purchase_status  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->hotel_confirm_code  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->flight_code  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->total_sell_price  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->total_buy_price  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->confirmedReceipt->sum('amount')  }}
                    </td>
                    <td class="hidden">
                        {{ $booking->confirmedBill->sum('amount')  }}
                    </td>
                    <td class="hidden">
                        @if($booking->campaign)
                            <p>{{ $booking->campaign->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        @if($booking->hotel)
                            <p>{{ $booking->hotel->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        @if($booking->sale)
                            <p>{{ $booking->sale->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        @if($booking->author)
                            <p>{{ $booking->author->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        @if($booking->agency)
                            <p>{{ $booking->agency->name }}</p>
                        @endif
                    </td>
                    <td class="hidden">
                        @if($booking->supplier)
                            <p>{{ $booking->supplier->name }}</p>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.booking.booking.edit', [$booking->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('admin.booking.booking.email', [$booking->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-envelope"></i></a>
                            <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.booking.booking.destroy', [$booking->id]) }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th width="3%">{{ trans('core::core.table.id') }}</th>
                    <th width="11%">{{ trans('booking::bookings.table.booking_number') }}</th>
                    <th width="11%">{{ trans('booking::bookings.table.campaign_id-hotel_id') }}</th>
                    <th width="7%">{{ trans('booking::bookings.table.agency_id-supplier_id') }}</th>
                    <th width="7%">{{ trans('booking::bookings.table.customer_id') }}</th>
                    <th width="8%">{{ trans('booking::bookings.table.checkin-checkout') }}</th>
                    <th width="17%">{{ trans('booking::bookings.table.status') }}</th>
                    <th width="10%">{{ trans('booking::bookings.table.hotel_confirm_code-flight_code') }}</th>
                    <th width="9%">{{ trans('booking::bookings.table.cod') }}</th>
                    <th width="8%">{{ trans('booking::bookings.table.sale_id-author_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.checkin') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.checkout') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.booking_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.payment_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.vendor_purchase_status') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.hotel_confirm_code') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.flight_code') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_sell_price') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_buy_price') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_receipt_amount') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.total_bill_amount') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.campaign_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.hotel_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.sale_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.author_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.agency_id') }}</th>
                    <th class="hidden">{{ trans('booking::bookings.table.supplier_id') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
                </tfoot>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>