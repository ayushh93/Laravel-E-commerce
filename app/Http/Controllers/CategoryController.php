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
        return view('admin.category.index');
    }

    //add category
    public function addCategory()
    {
        return view ('admin.category.add');
    }

    //store category
    public function storeCategory(Request $request)
    {
        $data=$request->all();
        $validateData = $request->validate([
            'category_name' => 'required|max:255',
            'category_code' => 'required|min:6',
         ]);
         $category=new Category();
         $category->category_name = ucwords(strtolower($data['category_name']));
         $category->category_code =$data['category_code'];
         $category->slug=str::slug($data['category_name']);
         $category->parent_id=$data['parent_id'];
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
}


