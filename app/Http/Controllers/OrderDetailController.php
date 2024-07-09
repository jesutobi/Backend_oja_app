<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function place_order(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_address_id' => 'required|exists:shipping_address,id',
            'payment_method' => 'required',
            'total_amount' => 'required|numeric',
            'total_item' => 'required|integer',
            'payment_status' => 'required|string',
            'ip_address' => 'json',
            'order_items' => 'required',
            'order_code' => 'required|string',
        ]);

        // $products = $request->order_items;
        $order =  OrderDetail::create([
            'user_id' => $request->user_id,
            'shipping_address_id' => $request->shipping_address_id,
            'payment_method' => $request->payment_method,
            'total_amount' => $request->total_amount,
            'total_item' => $request->total_item,
            'payment_status' => $request->payment_status,
            'order_status' => 'pending',
            'ip_address' => $request->ip_address,
            'order_code' => $request->order_code,
        ]);

        foreach ($request->order_items as $product) {
            $orderItem =  OrderItem::create([
                'order_details_id' => $order->id,
                'product_id' => $product['id'],
                'product_quantity' => $product['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'Your order has been placed',
            'orderItem' => $orderItem,
            'order' => $order
        ], 201);
    }
}
