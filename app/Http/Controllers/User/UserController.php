<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    public function userHome(){
        $products = Product::select('products.id','products.name','products.image','products.price','products.stock','products.description','products.category_id','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->when(request('categoryId'),function($query){
            $query->where('products.category_id',request('categoryId'));
        })
        ->when(request('searchKey'),function($query){
            $query->where('products.name','like','%'.request('searchKey').'%');
        })
        ->when(request('minPrice') != null && request('maxPrice') != null,function($query){
            $query->whereBetween('products.price',[request('minPrice'),request('maxPrice')]);
        })
        ->when(request('minPrice') != null && request('maxPrice') == null,function($query){
            $query->where('products.price','>=',request('minPrice'));
        })
        ->when(request('minPrice') == null && request('maxPrice') != null,function($query){
            $query->where('products.price','<=',request('maxPrice'));
        })
        ->when(request('sortingType'),function($query){
            $sortingRule = explode(',',request('sortingType'));
            $query->orderBy('products.'.$sortingRule[0],$sortingRule[1]);
        })
        ->get();
        $categories = Category::select()->get();
        return view('user.home.main',compact('products','categories'));
    }
    public function profile(){
        return view('user.home.account.profile');
    }
    public function profileEdit(Request $request){
        // dd($request->all());
        $this->checkValidation($request);
        $userData = $this->getData($request);
        if($request->hasFile('image')){
            if(Auth::user()->profile != null){
                if(file_exists(public_path('profile/') . Auth::user()->profile)){
                    unlink( public_path('profile/') . Auth::user()->profile);
                }
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/profile/',$fileName);
            $userData['profile'] = $fileName;
        }
        User::where('id',$request->userId)->update($userData);
        Alert::success('Success Title','User data is updated');
        return to_route('user#home');
    }
    //contact page
    public function contactPage(){
        return view('user.home.contact');
    }
    //store contact data
    public function storeContact(Request $request){
        Contact::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message,
        ]);
        Alert::success('Success Title','Your message was sent successfully!!');
        return back();
    }
    //add to cart
    public function addCart(Request $request){
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->count,
        ]);
        return to_route('cart#page');
    }
    //cart page
    public function cartPage(){
        $cartItems = Cart::select('carts.id','carts.user_id','carts.qty','products.id as product_id','products.name as product_name','products.image','products.price')
        ->leftJoin('products','carts.product_id','products.id')
        ->where('carts.user_id',Auth::user()->id)
        ->get();
        $totalCart = 0;
        $array = $cartItems->toArray();
        // dd(count($array));
        for($i = 0;$i < count($array);$i++){
            $price = $array[$i]['price']; //product price
            $qty = $array[$i]['qty']; // product quantity
            $totalCart += $price * $qty;
        }
        // dd($totalCart);
        return view('user.home.cart',compact('cartItems','totalCart'));
    }
    //delete cart item
    public function deleteCart(Request $request){
        // logger($request['cartId']);
        $cartId = $request['cartId'];
        Cart::where('id',$cartId)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'cart delete success'
        ],200);
    }
    //payment page
    public function paymentPage(){
        $paymentType = Payment::select('id','account_number','account_name','type')
        ->orderBy('type','asc')
        ->get();
        $orderTemp = Session::get('orderTemp');
        // dd($orderTemp);
        return view('user.home.payment',compact('paymentType','orderTemp'));
    }
    public function storeOrder(Request $request){
        // $this->paymentValidation($request);
        $tempStorage = Session::get('orderTemp');
        foreach($tempStorage as $row){
            Order::create([
                'user_id' => $row['user_id'],
                'product_id' => $row['product_id'],
                'count' => $row['count'],
                'status' => $row['status'],
                'order_code' => $row['order_code']
            ]);
            Cart::where('user_id',$row['user_id'])->where('product_id',$row['product_id'])->delete();
        }
        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];
        // dd($paymentHistoryData);
        if($request->hasFile('payslipImage')){
            $fileName = uniqid() . $request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path().'/PaymentImages/',$fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }
        PaymentHistory::create($paymentHistoryData);
        Alert::success('Success Title','Your Order has been completed');
        return to_route('user#orderList');
        //order create
        //payment history create
        //cart delete
    }
    // read order detail
    public function orderDetail($orderCode){
        // dd($orderCode);
        $orderProducts = Order::select('orders.status','orders.count','orders.order_code','orders.created_at','products.image','products.name','products.price','payment_histories.total_amt')
        ->where('orders.order_code',$orderCode)
        ->leftJoin('products','orders.product_id','products.id')
        ->leftJoin('payment_histories','orders.order_code','payment_histories.order_code')
        ->get();
        // dd($orderProducts->toArray());
        return view('user.home.orderDetail',compact('orderProducts'));
    }
    //tempStorage
    public function tempStorage(Request $request){
        $orderTemp = [];
        foreach($request->all() as $item){
            array_push($orderTemp,[
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'final_total' => $item['finalTotal']
            ]);
        }
        // logger($orderTemp);
        Session::put('orderTemp',$orderTemp);
        return response()->json([
            'status' => 'success',
            'message' => 'successfully store tempStorage'
        ]);
    }
    //order list page
    public function orderList(){
        $orderList = Order::where('user_id',Auth::user()->id)
                    ->groupBy('order_code')
                    ->orderBy('created_at','desc')
                    ->get();
        // dd($orderList);
        return view('user.home.orderList',compact('orderList'));
    }

    //product detail
    public function productDetail($id){
        $item = Product::select('products.id','products.name','products.image','products.price','products.stock','products.description','products.category_id','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)
        ->first();
        // dd($item->toArray());
        $comment = Comment::select('comments.id','comments.user_id','comments.product_id','comments.message','comments.created_at','users.name as user_name','users.profile')
        ->leftJoin('users','comments.user_id','users.id')
        ->where('comments.product_id',$id)
        ->get();
        $avg_rating = number_format(Rating::where('product_id',$id)->avg('count'));
        // dd($avg_rating);
        return view('user.home.product.detail',compact('item','comment','avg_rating'));
    }
    // store product comment
    public function storeComment(Request $request){
        Comment::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'message' => $request->comment,
        ]);
        Alert::success('Success Title','You commented successfully');
        return back();
    }
    //delete comment
    public function deleteComment($id){
        Comment::where('id',$id)->delete();
        return back();
    }
    //rating
    public function rating(Request $request){
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId
        ],[
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'count' => $request->productRating
        ]);
        Alert::success('Success Title','Rating created successfully');
        return back();
    }
    //password change page
    public function passwordPage(){
        return view('user.home.account.password');
    }
    //update password
    public function passwordChange(Request $request){
        $registeredPassword = Auth::user()->password;
        if(Hash::check($request->oldPassword, $registeredPassword)){
            $this->checkPassword($request);
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Alert::success('Success Title','Password Updated Successfully!');
            return back();
        }else{
            Alert::error('Process Fail..','Your old password does not match credentials! Try again');
            return back();
        }

    }
    //get edit profile form data
    private function getData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
    //profile validation process
    private function checkValidation($request){
        $request->validate([
            'name' => 'required|unique:users,email,'.$request->userId,
            'email' => 'required',
            'phone' => 'min:9|max:11'
        ]);
    }
    //password validation process
    private function checkPassword($request){
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|same:newPassword',
        ]);
    }
    //payment form validation
    private function paymentValidation($request){
        $request->validate([
            'phone' => 'required|min:9|max:11',
            'address' => 'required',
            'paymentType' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,svg,gif,webp,avif'
        ]);
    }

}
