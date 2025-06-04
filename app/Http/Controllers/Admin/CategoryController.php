<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function categoryPage(){
        $categories = Category::orderby('created_at', 'desc')->paginate(3);
        return view('admin.category.list',compact('categories'));
    }
    //create new category
    public function create(Request $request){
        $this->checkValidation($request);
        Category::create([
            'name' => $request->categoryName
        ]);
        Alert::success('Success Title', 'Success Created');
        return back();
    }
    //delete category
    public function delete($id){
        Category::where('id',$id)->delete();
        return back();
    }
    //edit category
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }
    public function update(Request $request, $id){
        $request['id'] = $id;
        $this->checkValidation($request);
        Category::where('id',$request->id)
        ->update([
            'name' => $request->categoryName
        ]);
        Alert::success('Success Title', 'Success Updated');
        return to_route('category#page');
    }

    private function checkValidation($request){
        $request->validate([
            'categoryName' => 'required|min:5|max:30|unique:categories,name,'.$request->id
        ],[
            'categoryName.required' => 'ဖြည့်ရန် လိုအပ်ပါသည်။'
        ]);
    }
}
