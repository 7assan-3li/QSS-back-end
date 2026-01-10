<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class UserBankController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $banks = $user->banks()
            ->withPivot('id', 'bank_account', 'is_active')
            ->get()
            ->map(function ($bank) {
                return [
                    'id'           => $bank->pivot->id,
                    'bank_id'      => $bank->id,
                    'bank_name'    => $bank->bank_name,
                    'bank_account' => $bank->pivot->bank_account,
                    'is_active'    => $bank->pivot->is_active,
                ];
            });


        return response()->json([
            'userBanks' => $banks,
        ]);
    }


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
            'is_active' => true,
        ]);


        return response()->json([
            'message' => 'تم إضافة الحساب البنكي بنجاح',
        ], 201);
    }

    public function show($account_id)
    {
        $userId = Auth::id();

        $userBank = DB::table('user_bank')
            ->join('banks', 'banks.id', '=', 'user_bank.bank_id')
            ->where('user_bank.id', $account_id)
            ->where('user_bank.user_id', $account_id)
            ->select(
                'user_bank.id as user_bank_id',
                'banks.id as bank_id',
                'banks.bank_name',
                'user_bank.bank_account',
                'user_bank.is_active'
            )
            ->first();

        if (! $userBank) {
            return response()->json([
                'message' => 'الحساب البنكي غير موجود'
            ], 404);
        }

        return response()->json([
            'bank' => $userBank
        ], 200);
    }

    public function update(Request $request, $userBankId)
    {
        $validated = $request->validate([
            'bank_id' => ['required', 'exists:banks,id'],
            'bank_account' => [
                'required',
                'integer',
                Rule::unique('user_bank')->where(function ($query) use ($request, $userBankId) {
                    return $query
                        ->where('user_id', Auth::id())
                        ->where('bank_id', $request->bank_id)
                        ->where('id', '!=', $userBankId);
                }),
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        // التأكد أن الحساب يخص المستخدم
        $userBank = DB::table('user_bank')
            ->where('id', $userBankId)
            ->where('user_id', Auth::id())
            ->first();

        if (! $userBank) {
            return response()->json([
                'message' => 'الحساب البنكي غير موجود'
            ], 404);
        }

        DB::transaction(function () use ($validated, $userBankId) {


            // تحديث الحساب (بما فيها تغيير البنك)
            DB::table('user_bank')
                ->where('id', $userBankId)
                ->update([
                    'bank_id'      => $validated['bank_id'],
                    'bank_account' => $validated['bank_account'],
                    'is_active'    => $validated['is_active'],
                    'updated_at'   => now(),
                ]);
        });

        return response()->json([
            'message' => 'تم تحديث الحساب البنكي بنجاح'
        ], 200);
    }
}
