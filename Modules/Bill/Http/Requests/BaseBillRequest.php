<?php

namespace Modules\Bill\Http\Requests;

use Modules\Bill\Entities\Bill;
use Modules\Core\Internationalisation\BaseFormRequest;

/**
 * Class BaseBillRequest
 * @package Modules\Bill\Http\Requests
 */
class BaseBillRequest extends BaseFormRequest
{
    /**
     * @param $booking
     * @param array $validationData
     * @param array $rules
     * @param int|null $billId
     * @return array
     */
    protected function addCustomRuleForDeductPaymentType($booking, array $validationData, array $rules, $billId = null)
    {
        $max = 0;

        if (!empty($booking)
            && !empty($validationData['payment_type']) && $validationData['payment_type'] === Bill::PAYMENT_TYPE_DEDUCT
            && !empty($validationData['parent_id'])) {
            $originalBill = Bill::find($validationData['parent_id']);
            if ($originalBill && $originalBill->type === Bill::TYPE_BOOKING_PAYMENT) {
                /**
                 * Case 1: phiếu chi nguồn là loại Thanh toán booking
                 * thì max = tổng số tiền các phiếu chi đã được xác nhận của booking nguồn -
                 * ( tổng nhập của booking nguồn + tổng tiền các phiếu chi khấu trừ từ booking nguồn);
                 * nếu max <= 0 thì clear và disable ô số tiền, báo "Không thể khấu trừ từ phiếu chi này"
                 */
                $queryConfirmedBillFromBookingAmount = Bill::where('status', Bill::STATUS_CONFIRMED)
                    ->where('booking_id', $booking->id);

                if (!empty($billId)) {
                    $queryConfirmedBillFromBookingAmount = $queryConfirmedBillFromBookingAmount->where('id', '!=', $billId);
                }
                $confirmedBillFromBookingAmount = $queryConfirmedBillFromBookingAmount->sum('amount');

                $totalBuyPrice = $booking->total_buy_price;

                $queryDeductBillFromBookingAmount = Bill::where('payment_type', Bill::PAYMENT_TYPE_DEDUCT)
                    ->where('booking_id', $booking->id);
                if (!empty($billId)) {
                    $queryDeductBillFromBookingAmount = $queryDeductBillFromBookingAmount->where('id', '!=', $billId);
                }
                $deductBillFromBookingAmount = $queryDeductBillFromBookingAmount->sum('amount');

                $max = $confirmedBillFromBookingAmount - ($totalBuyPrice + $deductBillFromBookingAmount);
            } else if ($originalBill && $originalBill->type === Bill::TYPE_OTHER_EXPENSE) {
                /**
                 * Case 2: phiếu chi nguồn là loại Chi phí khác thì
                 * max = số tiền của phiếu chi nguồn - tổng tiền các phiếu chi khấu trừ từ phiếu chi nguồn;
                 * nếu max <= 0 thì clear và disable ô số tiền, báo "Không thể khấu trừ từ phiếu chi này"
                 */
                $originalBillAmount = $originalBill->amount;
                $queryTotalDeductBillAmount = Bill::where('parent_id', $validationData['parent_id'])
                    ->where('payment_type', Bill::PAYMENT_TYPE_DEDUCT);
                if (!empty($billId)) {
                    $queryTotalDeductBillAmount = $queryTotalDeductBillAmount->where('id', '!=', $billId);
                }
                $totalDeductBillAmount = $queryTotalDeductBillAmount->sum('amount');
                $max = $originalBillAmount - $totalDeductBillAmount;
            }

            if ($max <= 0) {
                $rules['parent_id'] = 'required_if:payment_type,' . Bill::PAYMENT_TYPE_DEDUCT . '|exists:bill__bills,id|invalid_deduct_amount';
            } else {
                $rules['amount'] = 'required|min:1|numeric|max:' . $max;
            }
        }
        return $rules;
    }
}
