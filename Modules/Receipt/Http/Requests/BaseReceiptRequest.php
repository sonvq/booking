<?php

namespace Modules\Receipt\Http\Requests;

use Modules\Receipt\Entities\Receipt;
use Modules\Core\Internationalisation\BaseFormRequest;

/**
 * Class BaseReceiptRequest
 * @package Modules\Receipt\Http\Requests
 */
class BaseReceiptRequest extends BaseFormRequest
{
    /**
     * @param $booking
     * @param array $validationData
     * @param array $rules
     * @param int|null $receiptId
     * @return array
     */
    protected function addCustomRuleForDeductPaymentType($booking, array $validationData, array $rules, $receiptId = null)
    {
        $max = 0;

        if (!empty($booking)
            && !empty($validationData['payment_type']) && $validationData['payment_type'] === Receipt::PAYMENT_TYPE_DEDUCT
            && !empty($validationData['parent_id'])) {
            $originalReceipt = Receipt::find($validationData['parent_id']);
            if ($originalReceipt && $originalReceipt->type === Receipt::TYPE_BOOKING_PAYMENT) {
                /**
                 * Case 1: phiếu thu nguồn là loại Thanh toán booking  thì
                 * max = tổng số tiền các phiếu thu đã được xác nhận của booking nguồn
                 * - ( tổng bán của booking nguồn + tổng tiền các phiếu thu khấu trừ từ booking nguồn);
                 * nếu max <= 0 thì clear và disable ô số tiền, báo "Không thể khấu trừ từ phiếu thu này"
                 */
                $queryConfirmedReceiptFromBookingAmount = Receipt::where('status', Receipt::STATUS_CONFIRMED)
                    ->where('booking_id', $originalReceipt->booking_id);

                if (!empty($receiptId)) {
                    $queryConfirmedReceiptFromBookingAmount = $queryConfirmedReceiptFromBookingAmount->where('id', '!=', $receiptId);
                }
                $confirmedReceiptFromBookingAmount = $queryConfirmedReceiptFromBookingAmount->sum('amount');

                $totalSellPrice = $originalReceipt->booking->total_sell_price;

                $listReceiptIds = $originalReceipt->booking->receipt->pluck('id')->toArray();
                $queryDeductReceiptFromBookingAmount = Receipt::where('payment_type', Receipt::PAYMENT_TYPE_DEDUCT)
                    ->whereIn('parent_id', $listReceiptIds);
                if (!empty($receiptId)) {
                    $queryDeductReceiptFromBookingAmount = $queryDeductReceiptFromBookingAmount->where('id', '!=', $receiptId);
                }
                $deductReceiptFromBookingAmount = $queryDeductReceiptFromBookingAmount->sum('amount');
                $max = $confirmedReceiptFromBookingAmount - ($totalSellPrice + $deductReceiptFromBookingAmount);
            } else if ($originalReceipt && $originalReceipt->type === Receipt::TYPE_OTHER_EXPENSE) {
                /**
                 * Case 2: phiếu thu nguồn là loại Tiền khác thì
                 * max = số tiền của phiếu thu nguồn - tổng tiền các phiếu thu khấu trừ từ phiếu thu nguồn;
                 * nếu max <= 0 thì clear và disable ô số tiền, báo "Không thể khấu trừ từ phiếu thu này"
                 */
                $originalReceiptAmount = $originalReceipt->amount;
                $queryTotalDeductReceiptAmount = Receipt::where('parent_id', $validationData['parent_id'])
                    ->where('payment_type', Receipt::PAYMENT_TYPE_DEDUCT);
                if (!empty($receiptId)) {
                    $queryTotalDeductReceiptAmount = $queryTotalDeductReceiptAmount->where('id', '!=', $receiptId);
                }
                $totalDeductReceiptAmount = $queryTotalDeductReceiptAmount->sum('amount');
                $max = $originalReceiptAmount - $totalDeductReceiptAmount;
            }

            if ($max <= 0) {
                $rules['parent_id'] = 'required_if:payment_type,' . Receipt::PAYMENT_TYPE_DEDUCT . '|exists:receipt__receipts,id|invalid_deduct_amount';
            } else {
                $rules['amount'] = 'required|min:1|numeric|max:' . $max;
            }
        }
        return $rules;
    }
}
