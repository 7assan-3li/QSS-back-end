<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::latest()->get();

        return view('banks.index', ['banks' => $banks]);
    }
    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('banks', 'public');
        }

        Bank::create($validated);

        return to_route('banks.index')
            ->with('success', 'تم إضافة البنك بنجاح');
    }

    public function show($bank_id)
    {
        $bank = Bank::findOrFail($bank_id);
        return view('banks.show', ['bank' => $bank]);
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('banks.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $validated = $request->validate([
            'bank_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($bank->image_path && Storage::disk('public')->exists($bank->image_path)) {
                Storage::disk('public')->delete($bank->image_path);
            }

            $validated['image_path'] = $request->file('image')
                ->store('banks', 'public');
        }

        $bank->update($validated);

        return redirect()
            ->route('banks.show', $bank->id)
            ->with('success', 'تم تحديث بيانات البنك بنجاح');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        if ($bank->image_path && Storage::disk('public')->exists($bank->image_path)) {
            Storage::disk('public')->delete($bank->image_path);
        }

        $bank->delete();

        return redirect()
            ->route('banks.index')
            ->with('success', 'تم حذف البنك بنجاح');
    }

    //api functions
    public function getAllBanks()
    {
        $banks = Bank::all();
        return response()->json(['banks' => $banks]);
    }
}
