<?php

namespace Modules\Receipt\Entities;

use Modules\Booking\Entities\Booking;
use Modules\Core\Entities\BaseModel;

/**
 * Class Receipt
 * @package Modules\Receipt\Entities
 */
class Receipt extends BaseModel
{
    const TYPE_BOOKING_PAYMENT = 'booking_payment';
    const TYPE_OTHER_EXPENSE = 'other_expense';

    const PAYMENT_TYPE_CASH = 'cash';
    const PAYMENT_TYPE_BANK_TRANSFER = 'bank_transfer';
    const PAYMENT_TYPE_DEDUCT = 'deduct';

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    /**
     * @var string
     */
    protected $table = 'receipt__receipts';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'author_id',
        'type',
        'amount',
        'payment_type',
        'status',
        'note',
        'unique_number',
        'parent_id',
        'start_date'
    ];

    /**
     * @return array
     */
    public static function status()
    {
        return [
            '' => trans('receipt::receipts.form.status_choices.empty_status_option'),
            self::STATUS_PENDING => trans('receipt::receipts.form.status_choices.' . self::STATUS_PENDING),
            self::STATUS_CONFIRMED => trans('receipt::receipts.form.status_choices.' . self::STATUS_CONFIRMED),
        ];
    }

    /**
     * @return array
     */
    public static function type()
    {
        return [
            '' => trans('receipt::receipts.form.type_choices.empty_type_option'),
            self::TYPE_BOOKING_PAYMENT => trans('receipt::receipts.form.type_choices.' . self::TYPE_BOOKING_PAYMENT),
            self::TYPE_OTHER_EXPENSE => trans('receipt::receipts.form.type_choices.' . self::TYPE_OTHER_EXPENSE),
        ];
    }

    /**
     * @return array
     */
    public static function paymentType()
    {
        return [
            '' => trans('receipt::receipts.form.payment_type_choices.empty_payment_type_option'),
            self::PAYMENT_TYPE_CASH => trans('receipt::receipts.form.payment_type_choices.' . self::PAYMENT_TYPE_CASH),
            self::PAYMENT_TYPE_BANK_TRANSFER => trans('receipt::receipts.form.payment_type_choices.' . self::PAYMENT_TYPE_BANK_TRANSFER),
            self::PAYMENT_TYPE_DEDUCT => trans('receipt::receipts.form.payment_type_choices.' . self::PAYMENT_TYPE_DEDUCT),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class);
    }
}
