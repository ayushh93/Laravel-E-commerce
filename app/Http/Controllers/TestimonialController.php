<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class TestimonialController extends Controller
{
    //testimonial index
    public function testimonial(){
        Session::put('admin_page','testimonial');
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonial.testimonial', compact('testimonials'));
    }
    // Add Testimonial
    public function addTestimonial(){
        return view ('admin.testimonial.add');
    }
    // Store Testimonial
    public function storeTestimonial(Request $request){
        $data = $request->all();
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'position' => 'required|min:6',
            'image' => 'required',
            'description' => 'required',
        ]);
        $testimonial = new Testimonial();
        $testimonial->name = ucwords(strtolower($data['name']));
        $testimonial->position = ucwords(strtolower($data['position']));
        $testimonial->description = $data['description'];
        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path = 'public/uploads/testimonial/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $testimonial->image = $filename;
            }
        }
        $testimonial->save();
        Session::flash('success_message', 'Testimonail Has Been Added Successfully');
        return redirect()->route('testimonial.index');
    }
    // Edit testimonial
    public function editTestimonial($id){
        $testimonial = Testimonial::findOrFail($id);
        return view ('admin.testimonial.edit', compact('testimonial'));
    }

    // Update Testimonial
    public function updateTestimonial(Request $request, $id){
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->all();
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'position' => 'required|min:6',
            'description' => 'required',
        ]);
        $testimonial->name = ucwords(strtolower($data['name']));
        $testimonial->position = ucwords(strtolower($data['position']));
        $testimonial->description = $data['description'];
        $random = Str::random(10);
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path = 'public/uploads/testimonial/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $testimonial->image = $filename;
            }
        }
        $testimonial->save();

        $image_path = 'public/uploads/testimonial/';
        if(!empty($data['image'])) {
            if (!empty($data['current_image'])){
                if (file_exists($image_path . $data['current_image'])) {
                    unlink($image_path . $data['current_image']);
                }
            }
        }

        Session::flash('success_message', 'Testimonail Has Been updated Successfully');
        return redirect()->route('testimonial.index');
    }

    public function delete($id){
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        $image_path = 'public/uploads/testimonial/';
        if(!empty($testimonial->image)){
            if(file_exists($image_path.$testimonial->image)){
                unlink($image_path.$testimonial->image);
            }
        }
        Session::flash('success_message', 'Testimonial Has Been deleted Successfully');
        return redirect()->back();
    }



}
