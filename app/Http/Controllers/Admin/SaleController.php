<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    //
    public function saleInfo(){
        $saleInfo = PaymentHistory::select('payment_histories.user_name','payment_histories.address','payment_histories.phone','payment_histories.total_amt','payment_histories.order_code','orders.created_at')
        ->where('orders.status','=','1')
        ->groupBy('orders.order_code')
        ->leftJoin('orders','payment_histories.order_code','orders.order_code')
        ->get();
        // dd($saleInfo->toArray());
        $saleTotalPrice = PaymentHistory::where('orders.status','=',1)
        ->leftJoin('orders','payment_histories.order_code','orders.order_code')
        ->sum('payment_histories.total_amt');
        // dd($saleTotalPrice);
        // dd($saleInfo->toArray());
        return view('admin.sale.info',compact('saleInfo','saleTotalPrice'));
    }
}
