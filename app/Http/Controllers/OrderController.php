<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function show()
    {

        $orders = Order::with(['items.product', 'createdBy'])->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($order) {
            return [
                'orderNumber' => $order->id,
                'date' => $order->created_at->toDateString(),
                'items' => $order->items->map(function ($item) {
                    return [
                        'id'=>$item->product->id,
                        'name' => $item->product->name, // Assuming 'name' exists in the 'products' table
                        'quantity' => $item->quantity,
                        'price' => $item->unit_price,
                    ];
                }),
                'total' => $order->total_price,
                'status' => $order->status,
                'email' => $order->createdBy->email,
                'customerName' => $order->createdBy->first_name ?? 'Unknown', // Assuming the user model has a 'name' column
                'phone' => $order->createdBy->phone ?? 'N/A', // Assuming the user model has a 'phone' column
            ];
        });


      //  return response()->json($orders);

        return Inertia::render('Admin/Orders', [
            'orders' => $orders,
        ]);
    }


    public function view(Request $request)
    {
        $user = $request->user();


        $orders = Order::with(['items.product', 'createdBy'])->where(['created_by' => $user->id])->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'date' => $order->created_at->toDateString(),
                    'items' => $order->items->map(function ($item) {
                        return [
                            'name' => $item->product->name, // Assuming 'name' exists in the 'products' table
                            'quantity' => $item->quantity,
                            'price' => $item->unit_price,
                        ];
                    }),
                    'total' => $order->total_price,
                    'status' => $order->status,
                    'fullName' => $order->createdBy->name ?? 'Unknown', // Assuming the user model has a 'name' column
                    'phone' => $order->createdBy->phone ?? 'N/A', // Assuming the user model has a 'phone' column
                ];
            });


         return Inertia::render('Orders', [
             'orders' => $orders,
         ]);

    }


    public function adminView(Request $request)
    {

        $orders = Order::with(['items.product', 'createdBy'])->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'orderNumber' => $order->id,
                    'date' => $order->created_at->toDateString(),
                    'items' => $order->items->map(function ($item) {
                        return [
                            'id'=>$item->product->id,
                            'name' => $item->product->name, // Assuming 'name' exists in the 'products' table
                            'quantity' => $item->quantity,
                            'price' => $item->unit_price,
                        ];
                    }),
                    'total' => $order->total_price,
                    'status' => $order->status,
                    'email' => $order->createdBy->email,
                    'customerName' => $order->createdBy->first_name ?? 'Unknown', // Assuming the user model has a 'name' column
                    'phone' => $order->createdBy->phone ?? 'N/A', // Assuming the user model has a 'phone' column
                ];
            });


            return response()->json($orders);
    }

    public function changeStatus(Order $order)
    {
        $status = 'cancelled';
        DB::beginTransaction();
        try {
            $order->status = $status;
            $order->save();

         
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return back();

    }



    public function adminchangeStatus(Order $order,Request $request)
    {
  
        DB::beginTransaction();
        try {
            $order->status = $request->status;
            $order->save();

         
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

      //  return back();

    }

}
