<?php

namespace App\Http\Controllers;

use App\Models\VerificationPackages;
use App\Http\Requests\StoreVerificationPackageRequest;
use App\Http\Requests\UpdateVerificationPackageRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class VerificationPackagesController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $packages = VerificationPackages::where('is_active', true)->get();
        return response()->json(['packages' => $packages]);
    }

    public function show($id)
    {
        $package = VerificationPackages::findOrFail($id);
        return response()->json(['package' => $package]);
    }

    public function indexAdmin()
    {
        $this->authorize('viewAny', VerificationPackages::class);
        $packages = VerificationPackages::latest()->get();
        return view('verification_packages.index', compact('packages'));
    }

    public function create()
    {
        $this->authorize('create', VerificationPackages::class);
        return view('verification_packages.create');
    }

    public function store(StoreVerificationPackageRequest $request)
    {
        $this->authorize('create', VerificationPackages::class);
        VerificationPackages::create($request->validated());
        
        return redirect()->route('verification-packages.index');
    }

    public function showAdmin($id)
    {
        $package = VerificationPackages::findOrFail($id);
        $this->authorize('view', $package);
        return view('verification_packages.show', compact('package'));
    }

    public function edit($id)
    {
        $package = VerificationPackages::findOrFail($id);
        $this->authorize('update', $package);
        return view('verification_packages.edit', compact('package'));
    }

    public function update(UpdateVerificationPackageRequest $request, $id)
    {
        $package = VerificationPackages::findOrFail($id);
        $this->authorize('update', $package);
        $package->update($request->validated());
        
        return redirect()->route('verification-packages.show', $package->id)
            ->with('success', 'تم تحديث بيانات الباقة بنجاح');
    }

    public function destroy($id)
    {
        $package = VerificationPackages::findOrFail($id);
        $this->authorize('delete', $package);
        $package->delete();
        
        return redirect()->route('verification-packages.index')
            ->with('success', 'تم حذف الباقة بنجاح');
    }
}
