<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'user_id' => auth()->id(), // Set user_id dari user yang login
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized to edit this category!');
        }

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized to delete this category!');
        }

        if ($category->articles()->exists()) {
            return back()->with('error', 'Cannot delete category with articles!');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
}
