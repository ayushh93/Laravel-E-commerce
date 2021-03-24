<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            $random_password = 'password';
            //encode password
            $new_password = bcrypt($random_password);
            //update password
            Admin::where('email', $data['email'])->update(['password' => $new_password]);

            // Send Email
            $email = $data['email'];
            $name = $adminDetails->name;
            $messageData = ['email' => $data['email'], 'password' => $random_password, 'name' => $name];
            Mail::send('email.forgetpassword', $messageData, function($message) use ($email){
                $message->to($email)->subject('New Password - Hamro Shop Ecommerce');
            });

            return redirect()->back()->with('success_message', 'Please Check your email for updated password');


        }
        return view("admin.auth.forget");
    }
}
