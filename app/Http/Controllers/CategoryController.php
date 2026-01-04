<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewDashboard', User::class);
        $categories = Category::all()->where('category_id', null);
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
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($validated);
        return to_route('categories.index')->with('success', 'تم اضافة التصنيف بنجاح');
    }

    public function show(Category $category)
    {
        $category->load('children');

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
        return view('categories.edit', ['cat' => $category, 'categories' => $categories]);
    }
    public function update(Request $request, $category_id)
    {
        $category = Category::findOrFail($category_id);
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        $category->update($validated);
        return to_route('categories.index')->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy($category_id)
    {
        $this->authorize('delete', Category::class);
        $category = Category::findOrFail($category_id);
        $category->delete();
        return to_route('categories.index')->with('success', 'تم حذف التصنيف بنجاح');
    }
}
