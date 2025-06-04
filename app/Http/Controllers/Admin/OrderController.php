<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderList(){
        $orderList = Order::select('orders.user_id','orders.status','orders.order_code','orders.count as order_count','orders.created_at','users.name as customer_name','products.stock')
                    ->leftJoin('users','orders.user_id','users.id')
                    ->leftJoin('products','orders.product_id','products.id')
                    ->groupBy('orders.order_code')
                    ->orderBy('orders.created_at','desc')
                    ->get();
                    // dd($orderList->toArray());
        return view('admin.order.orderList',compact('orderList'));
    }
    public function orderDetail($orderCode){
        $paymentHistory = PaymentHistory::select('payment_histories.user_name','payment_histories.phone','payment_histories.address','payment_histories.payslip_image','payment_histories.order_code','payment_histories.total_amt','payment_histories.created_at','payments.type as payment_method')
        ->where('payment_histories.order_code',$orderCode)
                            ->leftJoin('payments','payment_histories.payment_method','payments.id')
                            ->first();

        //retrieve products that ordered
        $orderProducts = Order::select('orders.count as order_count','products.id as product_id','products.name as product_name','products.stock','products.price','products.image')
        ->where('orders.order_code',$orderCode)
        ->leftJoin('products','orders.product_id','products.id')
        ->get();
        // dd($orderProducts->toArray());
        $status = [];
        foreach($orderProducts as $item){
            if($item->order_count <= $item->stock){
                $status = true;
            }else{
                $status = false;
                break;
            }
        }
        // dd($status);

        return view('admin.order.orderDetail',compact('paymentHistory','orderProducts','status'));
    }

    public function changeStatus(Request $request){
        // logger($request->all());
        // logger($request->status);
        Order::where('order_code',$request->order_code)->update([
            'status' => $request->status
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'status changed successfully'
        ]);
    }

    public function confirmStatus(Request $request){
        // logger($request->all());
        Order::where('order_code',$request[0]['orderCode'])->update([
            'status' => 1
        ]);
        foreach($request->all() as $item){
            Product::where('id',$item['productId'])->decrement('stock',$item['count']);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'order confirm successfully'
        ],200);

    }
}
