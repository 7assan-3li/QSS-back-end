<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserBankController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => ['required', 'exists:banks,id'],
            'bank_account' => [
                'required',
                'integer',
                Rule::unique('user_bank')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id())
                        ->where('bank_id', $request->bank_id);
                }),
            ],
        ]);

        $user = Auth::user();



        // إضافة الحساب البنكي
        $user->banks()->attach($validated['bank_id'], [
            'bank_account' => $validated['bank_account'],
        ]);

        return response()->json([
            'message' => 'تم إضافة الحساب البنكي بنجاح',
        ], 201);
    }
}
