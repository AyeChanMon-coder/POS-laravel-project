<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function adminHome(){
        $saleTotalPrice = PaymentHistory::where('orders.status','=',1)
        ->leftJoin('orders','payment_histories.order_code','orders.order_code')
        ->sum('payment_histories.total_amt');

        $orderConfirm = Order::select('order_code',DB::raw('COUNT(*) as total'))
        ->groupBy('order_code')
        ->whereIn('status',[1])
        ->get();

        $orderPendingCount = Order::select('order_code',DB::raw('COUNT(*) as total'))
        ->groupBy('order_code')
        ->where('status','=','0')
        ->get();
        // dd($orderPendingCount->toArray());
        // dd('orderCount:',$orderCount->toArray());
        $userCount = User::where('role','=','user')->count();
        return view('admin.home.dashboard',compact('saleTotalPrice','orderConfirm','userCount','orderPendingCount'));
    }
    //new admin create page
    public function newAdminPage(){
        return view('admin.account.newAdmin');
    }
    //store new admin
    public function createAdmin(Request $request){
        $this->checkValidation($request);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);
        Alert::success('Success Title','New admin created!');
        return to_route('admin#list');
    }
    //admin list page
    public function adminList(){
        $adminList = User::select('id','name','nickname','email','address','phone','profile','role','provider','created_at')
        ->whereIn('role', ['admin','superadmin'])
        ->when(request('searchKey'),function($query){
            $query->whereAny(['name','nickname','email','address','phone'],'like','%'.request('searchKey').'%');
        })
        ->paginate(4);
        return view('admin.account.adminList',compact('adminList'));
    }
    //user list page
    public function userList(){
        $userList = User::select('id','name','nickname','email','address','phone','profile','role','provider','created_at')
        ->where('role','user')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['name','nickname','email','address','phone'],'like','%'.request('searchKey').'%');
        })
        ->paginate(4);
        return view('admin.account.userList',compact('userList'));
    }

    //delete admin data
    public function adminDelete($id){
        User::where('id',$id)->delete();
        return back();
    }
    //delete user data
    public function userDelete($id){
        User::where('id',$id)->delete();
        return back();
    }
    //check validation
    private function checkValidation($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12',
            'confirmPassword' => 'required|same:password',
        ]);
    }



}
