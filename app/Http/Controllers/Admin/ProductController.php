<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //product list page
    public function list($action = 'default'){
        $products = Product::select('products.id','products.name','products.image','products.price','products.stock','products.category_id','categories.name as category_name')
        ->orderBy('products.created_at','desc')
        ->leftJoin('categories','products.category_id','categories.id')
        ->when($action == 'lowAmt', function($query){
            $query->where('products.stock','<=',3);
        })
        ->when(request('searchKey'),function($query){
            $query->whereAny(['products.name','categories.name'], 'like', '%'.request('searchKey').'%');
        })
        ->paginate(3);
        return view('admin.product.list',compact('products'));
    }
    //product create form page
    public function create(){
        $categories = Category::get();
        return view('admin.product.create',compact('categories'));
    }
    //product store
    public function store(Request $request){
        $this->validationProcess($request,'action');
        $data = $this->getData($request);
        // dd($data);
        if($request->hasFile('image')){
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/productImages/',$fileName);
            $data['image'] = $fileName;
        }
        Product::create($data);
        Alert::success('Success Title','Product Created');
        return to_route('product#list');
    }
    //edit page
    public function edit($id){
        $categories = Category::get();
        $product = Product::where('id',$id)->first();
        // dd($product->toArray());
        return view('admin.product.editPage',compact('product','categories'));
    }
    //update process
    public function update(Request $request){
        $this->validationProcess($request,'update');
        $data = $this->getData($request);
        if($request->hasFile('image')){
            unlink(public_path('productImages/').$request->oldPhoto);
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/productImages/',$fileName);
            $data['image'] = $fileName;
        }
        Product::where('id',$request->productId)->update($data);
        Alert::success('Success Title','Product updated successfully');
        return to_route('product#list');
    }
    //see detail data
    public function detail($id){
        $product = DB::table('products')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name as category_name')
        ->where('products.id', $id)
        ->first();
        // dd($product);
        return view('admin.product.detail',compact('product'));
    }
    //delete data
    public function delete($id){
        $productOldImage = Product::where('id',$id)->value('image');
        if(file_exists(public_path('productImages/'.$productOldImage))){
            unlink(public_path('productImages/'.$productOldImage));
            Product::where('id',$id)->delete();
        }
        return back();
    }

    //get form data
    public function getData($request){
        return[
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock' => $request->stock,
        ];
    }

    //validate form data
    public function validationProcess($request,$action){
        $rules = [
            'image' => 'file|mimes:jpg,jpeg,png,svg,gif,webp,avif',
            'price' => 'required|numeric',
            'description' => 'required|min:10|max:2000',
            'categoryId' => 'required',
            'stock' => 'required',
        ];
        $message = [
            'name.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            'price.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            'description.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            'categoryId.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            'stock.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            'image.mimes' => 'ဖိုင်အမျိုးအစားမှန်ကန်မှုရှိရန်လိုအပ်ပါသည်'
        ];
        if($action == 'create'){
            $rules = [
                'name' => 'required|min:3|max:100|unique:products,name,'.$request->id,
            ];
            $message = [
                'image.required' => 'ဖြည့်ရန်လိုအပ်ပါသည်',
            ];
        }
        else if($action == 'update'){
            $rules = [
                'name' => 'required|min:3|max:100'
            ];
        }
        $request->validate($rules,$message);
    }

}
