<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use DB;

class CategoryController extends Controller
{
    //category index
    public function category()
    {
        Session::put('admin_page','category');

        $categories = Category::latest()->get();

        return view('admin.category.index', compact('categories'));
    }

    //add category
    public function addCategory()
    {
        Session::put('admin_page','category');
        $categories = Category::where('parent_id', 0)->orderBy('category_name','ASC')->get();
        return view ('admin.category.add',compact('categories'));

    }

    //store category
    public function storeCategory(Request $request)
    {
        $data=$request->all();
        $validateData = $request->validate([
            'category_name' => 'required|max:255',
            'category_code' => 'required|min:6',
         ]);
        $category = new Category();
        $category->category_name = ucwords(strtolower($data['category_name']));
        $category->category_code = $data['category_code'];
        $category->slug = Str::slug($data['category_name']);
        $category->parent_id = $data['parent_id'];


        if(empty($data['description']))
         {
             $category->description="";
         }
         else{
             $category->description = $data['description'];
         }
         if (empty($data['status']))
         {
            $category->status = 0;
          }
          else
          {
            $category->status = 1;
        }
        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path = 'public/uploads/category/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $category->image = $filename;
            }
        }
        $category->save();
        Session::flash('success_message', 'Category Has Been Added Successfully');
        return redirect()->back();
    }

    //edit category
    public function editCategory($id)
    {
        Session::put('admin_page', 'category');
        $myCategory = Category::findorfail($id);
        $categories = Category::where('parent_id', 0)->orderBy('category_name','ASC')->get();
        return view ('admin.category.edit',compact('categories', 'myCategory'));

    }
    // Update Category
    public function updateCategory(Request $request, $id){
        $data = $request->all();
        $validateData = $request->validate([
            'category_name' => 'required|max:255',
            'category_code' => 'required|min:6',
        ]);
        $category = Category::findOrFail($id);
        $category->category_name = ucwords(strtolower($data['category_name']));
        $category->category_code = $data['category_code'];
        $category->slug = Str::slug($data['category_name']);
        $category->parent_id = $data['parent_id'];
        if(empty($data['description'])){
            $category->description = "";
        } else {
            $category->description = $data['description'];
        }
        if (empty($data['status'])){
            $category->status = 0;
        } else {
            $category->status = 1;
        }

        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path = 'public/uploads/category/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $category->image = $filename;
            }
        }


        $image_path = 'public/uploads/category/';
        if(!empty($data['image'])) {
            if (file_exists($image_path . $data['current_image']))
            {
                unlink($image_path . $data['current_image']);
            }
        }


        $category->save();
        Session::flash('success_message', 'Category Has Been Updated Successfully');
        return redirect()->back();
    }

    //delete category
    public function deleteCategory($id)
    {
        $category = Category::findorFail($id);
        $category->delete();
        //if main category deletes subcategory also deletes
        DB::table('categories')->where('parent_id',$id)->delete();
        //product belonging to category also deletes
        DB::table('products')->where('category_id',$id)->delete();
        //delete image
        $image_path = 'public/uploads/category/';

        if(!empty($category->image)){
            if(file_exists($image_path.$category->image)){
                unlink($image_path.$category->image);
            }
        }
        Session::flash('success_message', 'Category Has Been deleted Successfully');
        return redirect()->back();

    }

    public function updateCategoryStatus(Request  $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }



}


