<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Product;
use App\Models\ProductImage;
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
        $products = Product::with('category')->latest()->get();
        return view('admin.product.index',compact('products'));
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
            'description' => 'required',
            'excerpt' => 'required',
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
    //edit product
    public function editProduct($id)
    {
        $product = Product::findorFail($id);
        $categories= Category::where('parent_id', 0)->where('status', 1)->get();
        $categories_dropdown = "<option value = '' selected disabled>Select Category</option>";
        foreach ($categories as $cat)
        {
            if($cat->id == $product->category_id)
            {
                $selected = "selected";
            }
            else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' $selected>".$cat->category_name."</option>";
            $sub_categories= Category::where(['parent_id'=>$cat->id])->where('status',1)->get();
            foreach($sub_categories as $sub_cat)
            {
                $categories_dropdown .= "<option value ='".$sub_cat->id."'> &nbsp; &nbsp; --- ".$sub_cat->category_name." </option>";
            }

        }
        return view('admin.product.edit',compact('product','categories_dropdown'));

    }
    //update product
    public function updateProduct(Request $request,$id)
    {
        $data=$request->all();
        $product = Product::findorFail($id);
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'description' => 'required',
            'excerpt' => 'required',
            'category_id'=> 'required'
        ]);
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
        //delete image
        $image_path = 'public/uploads/product/';
        if(!empty($data['image'])){
            if(file_exists($image_path.$data['current_image'])){
                unlink($image_path.$data['current_image']);
            }
        }
        $product->save();
        Session::flash('success_message', 'Category Has Been updated Successfully');
        return redirect()->back();
    }
    //delete product
    public function deleteProduct($id)
    {
        $product = Product::findorFail($id);
        $product->delete();
        //delete image
        $image_path = 'public/uploads/product/';

        if(!empty($product->image)){
            if(file_exists($image_path.$product->image)){
                unlink($image_path.$product->image);
            }
        }
        Session::flash('success_message', 'Product Has Been deleted Successfully');
        return redirect()->back();
    }
    //update product status
    public function updateProductStatus(Request  $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function addAttributes(Request $request, $id)
    {
        $product = Product::findorFail($id);
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    //checking duplicate SKU
                    $attrCountSKU = ProductAttribute::where('sku',$val)->count();
                    if($attrCountSKU>0)
                    {
                        return redirect()->back()->with('error_message','Product SKU already exists in our database');
                    }
                    //checking duplicate size
                    $attrCountSize= ProductAttribute::where(['product_id'=>$id , 'size'=>$data['size'][$key]])->count();
                    if($attrCountSize>0)
                    {
                        return redirect()->back()->with('error_message','Product Size already exists in our database');
                    }
                    $attribute = new ProductAttribute();
                    $attribute->product_id = $data['product_id'];
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            Session::flash('success_message', 'Product Attribute Has Been Added Successfully');
            return redirect()->back();
        }

        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        return view('admin.product.addAttribute',compact('product','productDetails'));
    }
    //delete product attribute
    public function deleteProductAttribute($id)
    {
        $productAttribute= ProductAttribute::findorFail($id);
        $productAttribute->delete();
        Session::flash('success_message', 'Product Attribute Has Been deleted Successfully');
        return redirect()->back();
    }
    //update product attribute
    public function editAttributes(Request $request, $id=null)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            foreach($data['idAttr'] as $key=>$attr)
            {
               ProductAttribute::where('id',$data['idAttr'][$key])->update(['price' => $data['price'][$key],'size' => $data['size'][$key], 'stock' => $data['stock'][$key],'sku' => $data['sku'][$key]]);
            }
            Session::flash('success_message', 'Product Attribute Has Been updated Successfully');
            return redirect()->back();
        }

    }
    public function addAltImage(Request  $request, $id){
        $product = Product::findOrFail($id);
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach ($files as $file){
                    $image = new ProductImage();
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(11,99999).'.'.$extension;
                    $image_path = 'public/uploads/product/' . $filename;
                    Image::make($file)->save($image_path);
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            Session::flash('success_message', 'Product Image Has Been Added Successfully');
            return redirect()->back();
        }
        $productImages = ProductImage::where('product_id', $id)->get();
        return view ('admin.product.addAltImage', compact('product','productImages'));
    }
    public function deleteProductImage($id){
        $image = ProductImage::findOrFail($id);
        $image->delete();
        $image_path = 'public/uploads/product/';
        if(!empty($image->image)){
            if(file_exists($image_path.$image->image)){
                unlink($image_path.$image->image);
            }
        }
        Session::flash('success_message', 'Product Image Has Been deleted Successfully');
        return redirect()->back();
    }



}
