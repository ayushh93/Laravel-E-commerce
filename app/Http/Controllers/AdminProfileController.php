<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminProfileController extends Controller
{
    //admin profile
    public function profile()
    {
        $admin = Auth::guard('admin')->user(); //get id of user that is logged in
        return view ('admin.profile' , compact('admin'));
    }

    //update profile
    public function updateProfile(Request $request, $id)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required | max:255',
            'email' => 'required | email | max:255',
            'phone' => 'required',
            'address' => 'required',
        ];
        $customMessages= [
            'name.required' => 'Please enter the name',
            'name.max' => 'Max 255 character allowed',
            'email.required' => 'Please enter the email',
            'email.max' => 'Max 255 character allowed',
            'email.email' => 'PLease enter valid email address',
            'phone.required' => 'Please enter the phone number',
            'address.required' => 'Please enter the address',
        ];
        $this->validate($request, $rule, $customMessages);
        $admin_id = Auth::guard('admin')-> user()->id;
        $admin = Admin::findOrFail($admin_id);
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->phone = $data['phone'];
        $admin->address = $data['address'];
        $admin->save();
        Session::flash('success_message', 'Admin profile has been updated succesfully');
        return redirect()->back();

    
    }
       
}
