<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ThemeController extends Controller
{
    //theme
    public function theme()
    {
        $theme=Theme::first();
        return view('admin.setting.theme',compact('theme'));

    }

    //update theme
    public function themeUpdate(Request $request,$id)
    {
        $data = $request->all();
        $theme = Theme::findorFail($id);
        $theme->site_title = $data['site_title'];
        $theme->site_subtitle = $data['site_subtitle'];
        $random = str::random(10);
        if($request->hasFile('logo'))
        {
            $image_tmp = $request->file('logo');
            if($image_tmp->isvalid())
            {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $random . '.' . $extension;
                $image_path='public/uploads/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $theme->logo = $filename;
            }
        }
    $currentDate = Carbon::now()->toDateString();
        $slug2 = 'favicon';
        if($request->hasFile('favicon'))
        {
            $image_tmp = $request->file('favicon');
            if($image_tmp->isvalid())
            {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = $slug2 . '-' . $currentDate . '.' . $extension;
                $image_path='public/uploads/' . $filename;
                Image::make($image_tmp)->save($image_path);
                $theme->favicon = $filename;
            }
        }
        $theme->save();
        Session::flash('success_message', 'Theme settings has been updated succesfully');
        return redirect()->back();
    }
}
