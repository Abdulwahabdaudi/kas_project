<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request) {

        $user = $request->user();
        $totalPrice = $request[0];
        $orderItems = $request[1];
        //$customer = $user->customer;
        try {

            // Create Order
            $orderData = [
                'total_price' => $totalPrice,
                'status' => OrderStatus::Pending,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ];
            $order = Order::create($orderData);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $orderItem['id'],
                    'quantity'=> $orderItem['quantity'],
                    'unit_price'=> $orderItem['price'],
                
                ]);


            }

            // Create Payment
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'status' => PaymentStatus::Pending,
                'type' => 'cash',
                //'created_by' => $user->id,
                //'updated_by' => $user->id,
    //            'session_id' => $session->id
            ];
            Payment::create($paymentData);

        } catch (\Exception $e) {
           // DB::rollBack();

            throw $e;
        }

      

    }
}
