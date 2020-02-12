<?php

namespace Modules\Booking\Entities;

use Modules\Bill\Entities\Bill;
use Modules\Core\Entities\BaseModel;
use Modules\Receipt\Entities\Receipt;

/**
 * Class Booking
 * @package Modules\Booking\Entities
 */
class Booking extends BaseModel
{
    const BOOKING_STATUS_CREATED = 'created';

    const BOOKING_STATUS_HOTEL_SENT = 'hotel_sent';

    const BOOKING_STATUS_HOTEL_CONFIRMED = 'hotel_confirmed';

    const BOOKING_STATUS_HOTEL_REJECTED = 'hotel_rejected';

    const BOOKING_STATUS_CUSTOMER_REJECTED = 'customer_rejected';

    const BOOKING_STATUS_PENALTY_FOR_CANCELLATION = 'penalty_for_cancellation';

    const PAYMENT_STATUS_PENDING = 'pending';

    const PAYMENT_STATUS_PAYMENT_CONFIRMATION = 'payment_confirmation';

    const PAYMENT_STATUS_PARTIALLY_PAID = 'partially_paid';

    const PAYMENT_STATUS_FULLY_PAID = 'fully_paid';

    const VENDOR_PURCHASE_STATUS_PENDING = 'pending';

    const VENDOR_PURCHASE_STATUS_COMPLETED = 'completed';

    const VENDOR_PURCHASE_STATUS_PARTIALLY_PAID = 'partially_paid';
    /**
     * @var string
     */
    protected $table = 'booking__bookings';
    /**
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'agency_id',
        'supplier_id',
        'sale_id',
        'customer_id',
        'author_id',

        'checkin_date',
        'checkout_date',

        'hotel_confirm_code',
        'flight_code',

        'campaign_id',

        'is_adjust_surcharge',
        'is_adjust_price',

        'note',

        'total_price',
        'total_buy_price',
        'total_sell_price',
        'total_profit',

        'booking_number',
        'cod',

        'booking_status',
        'payment_status',
        'vendor_purchase_status',
    ];

    /**
     * @return array
     */
    public static function bookingStatus()
    {
        return [
            self::BOOKING_STATUS_CREATED => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_CREATED),
            self::BOOKING_STATUS_HOTEL_SENT => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_HOTEL_SENT),
            self::BOOKING_STATUS_HOTEL_CONFIRMED => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_HOTEL_CONFIRMED),
            self::BOOKING_STATUS_HOTEL_REJECTED => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_HOTEL_REJECTED),
            self::BOOKING_STATUS_CUSTOMER_REJECTED => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_CUSTOMER_REJECTED),
            self::BOOKING_STATUS_PENALTY_FOR_CANCELLATION => trans('booking::bookings.form.booking_status_choices.' . self::BOOKING_STATUS_PENALTY_FOR_CANCELLATION),
        ];
    }

    /**
     * @return array
     */
    public static function paymentStatus()
    {
        return [
            self::PAYMENT_STATUS_PENDING => trans('booking::bookings.form.payment_status_choices.' . self::PAYMENT_STATUS_PENDING),
            self::PAYMENT_STATUS_PAYMENT_CONFIRMATION => trans('booking::bookings.form.payment_status_choices.' . self::PAYMENT_STATUS_PAYMENT_CONFIRMATION),
            self::PAYMENT_STATUS_PARTIALLY_PAID => trans('booking::bookings.form.payment_status_choices.' . self::PAYMENT_STATUS_PARTIALLY_PAID),
            self::PAYMENT_STATUS_FULLY_PAID => trans('booking::bookings.form.payment_status_choices.' . self::PAYMENT_STATUS_FULLY_PAID),
        ];
    }

    /**
     * @return array
     */
    public static function vendorPurchaseStatus()
    {
        return [
            self::VENDOR_PURCHASE_STATUS_PENDING => trans('booking::bookings.form.vendor_purchase_status_choices.' . self::VENDOR_PURCHASE_STATUS_PENDING),
            self::VENDOR_PURCHASE_STATUS_COMPLETED => trans('booking::bookings.form.vendor_purchase_status_choices.' . self::VENDOR_PURCHASE_STATUS_COMPLETED),
            self::VENDOR_PURCHASE_STATUS_PARTIALLY_PAID => trans('booking::bookings.form.vendor_purchase_status_choices.' . self::VENDOR_PURCHASE_STATUS_PARTIALLY_PAID),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(\Modules\Room\Entities\Room::class, 'room_bookings', 'booking_id', 'room_id')
            ->withTimestamps()
            ->withPivot([
                'quantity',
                'start_date',
                'end_date',
                'buy_price',
                'sell_price'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(\Modules\Service\Entities\Service::class, 'service_bookings', 'booking_id', 'service_id')
            ->withTimestamps()
            ->withPivot([
                'quantity',
                'start_date',
                'end_date',
                'buy_price',
                'sell_price'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function surcharges()
    {
        return $this->belongsToMany(\Modules\Surcharge\Entities\Surcharge::class, 'surcharge_bookings', 'booking_id', 'surcharge_id')
            ->withTimestamps()
            ->withPivot([
                'quantity',
                'start_date',
                'end_date',
                'buy_price',
                'sell_price'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(\Modules\Customer\Entities\Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(\Modules\Hotel\Entities\Hotel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo(\Modules\Agency\Entities\Agency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(\Modules\Supplier\Entities\Supplier::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(\Modules\Campaign\Entities\Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'booking_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function confirmedReceipt()
    {
        return $this->hasMany(Receipt::class, 'booking_id', 'id')
            ->where('status', Receipt::STATUS_CONFIRMED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bill()
    {
        return $this->hasMany(Bill::class, 'booking_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function confirmedBill()
    {
        return $this->hasMany(Bill::class, 'booking_id', 'id')
            ->where('status', Bill::STATUS_CONFIRMED);
    }
}
