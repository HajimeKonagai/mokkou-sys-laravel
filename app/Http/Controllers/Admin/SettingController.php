<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function get(string $key)
    {
        $setting = Setting::where('key', $key)
            ->first();
        
        return $setting ? $setting->value: config($key); 
    }


    public function update(string $key, Request $request)
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $request->preference]
        );

        return response($setting->value, 200)
            ->header('Content-Type', 'text/plain');
    }


    public function destroy(string $key)
    {
        $setting = Setting::where('key', $key)
            ->first();

        if ($setting)
        {
            $setting->delete();
        }
    }
}
