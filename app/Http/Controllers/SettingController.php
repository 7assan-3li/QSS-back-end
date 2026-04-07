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
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // Determine if we need to reset user policies (only if text changed)
                if (in_array($key, ['seeker_policy_content', 'provider_policy_content']) && $setting->value !== $value) {
                    if ($key === 'seeker_policy_content') {
                        \App\Models\User::where('role', 'seeker')->update(['seeker_policy' => false]);
                    } else {
                        \App\Models\User::where('role', 'provider')->update(['provider_policy' => false]);
                    }
                }

                // Update the setting value (handle both numeric and text)
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'تم حفظ وتحديث إعدادات النظام الحساسة والسياسات العامة بنجاح!');
    }
}
