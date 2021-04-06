<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    //product index
    public function product()
    {
        Session::put('admin_page','Product');
        return view('admin.product.index');
    }

    //add product
    public function addProduct()
    {
        $categories= Category::where('parent_id', 0)->where('status', 1)->get();
        $categories_dropdown = "<option value = '' selected disabled>Select Category</option>";
        foreach ($categories as $cat)
        {
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->category_name."</option>";
            $sub_categories= Category::where(['parent_id'=>$cat->id])->where('status',1)->get();
            foreach($sub_categories as $sub_cat)
            {
                $categories_dropdown .= "<option value ='".$sub_cat->id."'> &nbsp; &nbsp; --- ".$sub_cat->category_name." </option>";
            }

        }
        return view('admin.product.add',compact('categories_dropdown'));
    }
    //store product
    public function storeProduct(Request $request)
    {
        $data=$request->all();
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
        ]);
        $product=new Product();
        $product->product_name = $data['product_name'];
        $product->category_id = $data['category_id'];
        $product->price = $data['price'];
        $product->slug = Str::slug($data['product_name']);
        $product->product_name = $data['product_name'];
        if(empty($data['description']))
        {
            $product->description="";
        }
        else{
            $product->description = $data['description'];
        }
        if(empty($data['excerpt']))
        {
            $product->excerpt="";
        }
        else{
            $product->excerpt = $data['excerpt'];
        }
        if (empty($data['status']))
        {
            $product->status = 0;
        }
        else
        {
            $product->status = 1;
        } if (empty($data['featured_product']))
        {
            $product->featured_product = 0;
        }
        else
        {
            $product->featured_product = 1;
        }
        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path = 'public/uploads/product/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $product->image = $filename;
            }
        }
        $product->save();
        Session::flash('success_message', 'Category Has Been Added Successfully');
        return redirect()->back();
    }
}
