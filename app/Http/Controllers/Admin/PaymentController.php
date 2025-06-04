<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //payment info read
    public function list(){
        $accountInfo = Payment::select()
        ->orderBy('type','asc')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['account_number','account_name','type'],'like','%'.request('searchKey').'%');
        })
        ->paginate(4);
        return view('admin.payment.list',compact('accountInfo'));
    }
    //payment method create
    public function create(Request $request){
        $this->checkValidation($request);
        $accountInfo = $this->getAccount($request);
        Payment::create($accountInfo);
        Alert::success('Success Title','Payment Info created successfully!');
        return back();
    }
    //payment edit page
    public function edit($id){
        $account = Payment::where('id',$id)->first();
        return view('admin.payment.edit',compact('account'));
    }
    // payment update
    public function update(Request $request){
        $this->checkValidation($request);
        $data = $this->getAccount($request);
        $data['id'] = $request->accountId;
        Payment::where('id',$request->accountId)->update($data);
        Alert::success('Success Title','Payment Info created successfully!');
        return to_route('payment#list');
    }
    //payment delete
    public function delete($id){
        Payment::where('id',$id)->delete();
        return back();
    }
    //check validation
    private function checkValidation($request){
        $request->validate([
            'accountNumber' => 'required|min:10|max:20',
            'accountName' => 'required',
            'accountType' => 'required|min:3',
        ]);
    }
    //get account info
    private function getAccount($request){
        return[
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType,
        ];
    }
}
