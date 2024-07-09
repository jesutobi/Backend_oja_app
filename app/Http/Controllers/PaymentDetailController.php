<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;

class PaymentDetailController extends Controller
{
    public function payment_details(Request $request)
    {
        $data = $request->validate([
            'order_details_id' => 'required',
            'payment_status' => 'required|string',
            'transaction_code' => 'required|string',
            'reference_code' => 'required|string',
        ]);

        $paymentDetails = PaymentDetail::create([
            'order_details_id' => $data['order_details_id'],
            'payment_status' => $data['payment_status'],
            'transaction_code' => $data['transaction_code'],
            'reference_code' => $data['reference_code']
        ]);

        if ($data['payment_status'] === 'success') {
            $orderDetail = OrderDetail::find($data['order_details_id']);
            if ($orderDetail && $orderDetail->payment_status === 'unpaid') {
                $orderDetail->payment_status = 'paid';
                $orderDetail->save();
            }
        }
        return response()->json([
            'message' => 'Payment details saved'
        ], 201);
    }
}
