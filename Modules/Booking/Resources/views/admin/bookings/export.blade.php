<table class="data-table table table-bordered table-hover">
    <thead>
    <tr>
        <th>{{ trans('core::core.table.id') }}</th>
        <th>{{ trans('booking::bookings.table.booking_number') }}</th>
        <th>{{ trans('booking::bookings.table.campaign_id') }}</th>
        <th>{{ trans('booking::bookings.table.hotel_id') }}</th>
        <th>{{ trans('booking::bookings.table.agency_id') }}</th>
        <th>{{ trans('booking::bookings.table.customer_id') }}</th>
        <th>{{ trans('booking::bookings.table.checkin') }}</th>
        <th>{{ trans('booking::bookings.table.checkout') }}</th>
        <th>{{ trans('booking::bookings.table.booking_status') }}</th>
        <th>{{ trans('booking::bookings.table.payment_status') }}</th>
        <th>{{ trans('booking::bookings.table.vendor_purchase_status') }}</th>
        <th>{{ trans('booking::bookings.table.hotel_confirm_code') }}</th>
        <th>{{ trans('booking::bookings.table.flight_code') }}</th>
        <th>{{ trans('booking::bookings.table.cod') }}</th>
        <th>{{ trans('booking::bookings.table.sale_id') }}</th>
        <th>{{ trans('booking::bookings.table.author_id') }}</th>
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
            {{ $booking->id }}
        </td>
        <td>
            {{ $booking->booking_number }}
        </td>
        <td>
            @if($booking->campaign)
                {{ $booking->campaign->name }}
            @endif
        </td>
        <td>
            @if($booking->hotel)
                {{ $booking->hotel->name }}
            @endif
        </td>
        <td>
            @if($booking->agency)
                {{ $booking->agency->name }}
            @endif
        </td>
        <td>
            @if($booking->customer)
                {{ $booking->customer->name }}
            @endif
        </td>
        <td>
            {{ $checkinDate  }}
        </td>
        <td>
            {{ $checkoutDate  }}
        </td>
        <td>
            @if(isset($bookingStatuses[$booking->booking_status]))
                {{ $bookingStatuses[$booking->booking_status] }}
            @endif
        </td>
        <td>
            @if(isset($paymentStatuses[$booking->payment_status]))
                {{ $paymentStatuses[$booking->payment_status] }}
            @endif
        </td>
        <td>
            @if(isset($vendorPurchaseStatuses[$booking->vendor_purchase_status]))
                {{ $vendorPurchaseStatuses[$booking->vendor_purchase_status] }}
            @endif
        </td>
        <td>
            {{ $booking->hotel_confirm_code }}
        </td>
        <td>
            {{ $booking->flight_code }}
        </td>
        <td>
            {{ $codDate }}
        </td>
        <td>
            @if($booking->sale)
                {{ $booking->sale->name }}
            @endif
        </td>
        <td>
            @if($booking->author)
                {{ $booking->author->name }}
            @endif
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>