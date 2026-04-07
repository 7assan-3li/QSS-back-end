<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    public function getSeekerPolicy()
    {
        $seekerPolicy = \App\Models\Setting::where('key', 'seeker_policy_content')->first();
        return response()->json([
            'seeker_policy' => $seekerPolicy,
        ]);
    }
    public function getProviderPolicy()
    {
        $providerPolicy = \App\Models\Setting::where('key', 'provider_policy_content')->first();
        return response()->json([
            'provider_policy' => $providerPolicy,
        ]);
    }
    /**
     * Accept the Seeker policy for the authenticated user.
     */
    public function acceptSeekerPolicy()
    {
        $user = Auth::user();
        
        $user->update(['seeker_policy' => true]);

        return response()->json([
            'message' => 'تمت الموافقة على سياسة طالب الخدمة بنجاح',
            'seeker_policy' => true
        ]);
    }

    /**
     * Accept the Provider policy for the authenticated user.
     */
    public function acceptProviderPolicy()
    {
        $user = Auth::user();

        $user->update(['provider_policy' => true]);

        return response()->json([
            'message' => 'تمت الموافقة على سياسة مزود الخدمة بنجاح',
            'provider_policy' => true
        ]);
    }
}
