<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewDashboard', User::class);
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }
    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = Category::whereNull('category_id')
            ->with('childrenRecursive')
            ->get();
        return view('categories.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image_path' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')
                ->store('category', 'public');
        }

        Category::create($validated);
        return to_route('categories.index')->with('success', 'تم اضافة التصنيف بنجاح');
    }

    public function show(Category $category)
    {
        $category->with(['children','services'])->get();

        return view('categories.show', compact('category'));
    }


    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);
        $this->authorize('update', $category);
        $categories = Category::whereNull('category_id')
            ->with('childrenRecursive')
            ->where('id', '!=', $category->id) // منع اختيار نفس التصنيف أب لنفسه
            ->get();
        return view('categories.edit', ['category' => $category, 'categories' => $categories]);
    }
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // تحديث بيانات النصوص
        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? null;
        $category->category_id = $validated['category_id'] ?? null;

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا موجودة
            if ($category->image_path && Storage::disk('public')->exists($category->image_path)) {
                Storage::disk('public')->delete($category->image_path);
            }

            // حفظ الصورة الجديدة
            $path = $request->file('image')->store('categories', 'public');
            $category->image_path = $path;
        }

        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح!');
    }

    public function destroy(Category $category)
    {
        // تحقق أولًا إن أي تصنيف في الشجرة مرتبط بخدمات
        if ($this->hasServicesInTree($category)) {
            return redirect()->route('categories.index')
                ->with('error', 'لا يمكن حذف هذا التصنيف أو أحد أبنائه لأنه مرتبط بخدمات');
        }

        // حذف الصور وجميع الأبناء بشكل متكرر
        $this->deleteCategoryTree($category);

        return redirect()->route('categories.index')
            ->with('success', 'تم حذف التصنيف وكل أبنائه بنجاح!');
    }

    /**
     * تحقق إذا كان هذا التصنيف أو أي من أبنائه لديه خدمات
     */
    protected function hasServicesInTree(Category $category): bool
    {
        if ($category->services()->exists()) {
            return true;
        }

        foreach ($category->children as $child) {
            if ($this->hasServicesInTree($child)) {
                return true;
            }
        }

        return false;
    }

    /**
     * حذف التصنيف وأبنائه بشكل متكرر مع الصور
     */
    protected function deleteCategoryTree(Category $category)
    {
        // حذف الأبناء أولاً
        foreach ($category->children as $child) {
            $this->deleteCategoryTree($child);
        }

        // حذف صورة هذا التصنيف
        if ($category->image_path && Storage::disk('public')->exists($category->image_path)) {
            Storage::disk('public')->delete($category->image_path);
        }

        // حذف التصنيف نفسه
        $category->delete();
    }

    //api functions

    public function displayMain()
    {
        $categories = Category::with('children')->whereNull('category_id')->get();

        return response()->json(['categories' => $categories], 200);
    }

    public function showCategory($category_id){
        $category = Category::with(['children','services'])->findOrFail($category_id);
                return response()->json(['category' => $category], 200);

    }
}
