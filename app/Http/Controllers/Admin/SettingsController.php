<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function viewSettingsPage(){
        $setting = Setting::firstOrCreate([]);
        return view('dashboard.settings',compact('setting'));
    }

    public function submitSettings(Request $request){
        $settingFields = $request->validate([
            'logo' => ['nullable','max:10'],
            'site_description' => ['nullable','max:100'],
            'title' => ['nullable','max:100'],
            'copyright' => ['nullable','max:100'],
            'about' => ['nullable','max:2000']
        ]);
        $setting = Setting::first();
        if($setting === null){
            Setting::create($settingFields);
        }else{
            $setting->update($settingFields);
        }
        return redirect()->route('admin.view.settings')->with('success','تنظیمات با موفقیت بروزرسانی شد');
    }
}