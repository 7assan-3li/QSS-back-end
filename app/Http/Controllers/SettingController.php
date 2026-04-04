<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function indexAdmin()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function updateAdmin(Request $request)
    {
        $settingsData = $request->except(['_token', '_method']);

        foreach ($settingsData as $key => $value) {
            // التحقق من أن القيمة رقمية وأن المفتاح موجود لتلافي أي أخطاء
            if(is_numeric($value)) {
                Setting::where('key', $key)->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'تم حفظ وتحديث إعدادات النظام الحساسة بنجاح!');
    }
}
