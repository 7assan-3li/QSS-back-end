<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankSystemAccountRequest;
use App\Http\Requests\UpdateBankSystemAccountRequest;
use App\Models\Bank;
use App\Models\BankSystemAccount;
use App\Services\BankSystemAccountService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BankSystemAccountController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(BankSystemAccountService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('viewAny', BankSystemAccount::class);
        $accounts = BankSystemAccount::with('bank')->latest()->paginate(10);
        return view('admin.bank_accounts.index', compact('accounts'));
    }

    public function create()
    {
        $this->authorize('create', BankSystemAccount::class);
        $banks = Bank::all();
        return view('admin.bank_accounts.create', compact('banks'));
    }

    public function store(StoreBankSystemAccountRequest $request)
    {
        $this->authorize('create', BankSystemAccount::class);
        $this->service->create($request->validated());

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', __('تم إضافة الحساب البنكي بنجاح'));
    }

    public function edit(BankSystemAccount $bankAccount)
    {
        $this->authorize('update', $bankAccount);
        $banks = Bank::all();
        return view('admin.bank_accounts.edit', compact('bankAccount', 'banks'));
    }

    public function update(UpdateBankSystemAccountRequest $request, BankSystemAccount $bankAccount)
    {
        $this->authorize('update', $bankAccount);
        $this->service->update($bankAccount, $request->validated());

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', __('تم تحديث بيانات الحساب بنجاح'));
    }

    public function destroy(BankSystemAccount $bankAccount)
    {
        $this->authorize('delete', $bankAccount);
        $this->service->delete($bankAccount);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', __('تم حذف الحساب بنجاح'));
    }

    /**
     * API: Get active platform bank accounts for users.
     */
    public function getPlatformAccounts()
    {
        $accounts = BankSystemAccount::where('is_active', true)
            ->with('bank:id,bank_name,image_path')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $accounts
        ]);
    }
}
