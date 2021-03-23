<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    //admin login
    public function adminLogin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']]))
            {
                return redirect ('/admin/dashboard');
            }
            else
            {
                return redirect('/admin/login');
            }
        }
        return view("admin.auth.login");
    }

    //admin dashboard
    public function dashboard(){
     return view("admin.dashboard");
    }
    //admin logout
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    //forget password
    public function forgetPassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $validateData = $request->validate([
                'email' => 'required'
            ]);
            $adminCount = Admin::where('email', $data['email'])->count();
            if($adminCount == 0)
            {
                return redirect()->back()->with('error_message','User doesnt exist in our database');
            }
            //get admin details
            $adminDetails = Admin::where('email', $data['email'])->first();
            //generate password
            $random_password = Str::random(10);
            //encode password
            $new_password = bcrypt($random_password);
            //update password
            Admin::where('email', $data['email'])->update(['password' => $new_password]);

        }
        return view("admin.auth.forget");
    }
}
