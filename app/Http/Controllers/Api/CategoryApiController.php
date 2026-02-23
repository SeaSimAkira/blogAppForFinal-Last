<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryApiController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = Category::with('parent:id,name')
            ->orderBy('name')
            ->paginate(10);

        return response()->json($categories, 200);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:75',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('images/categories', 'public');
            $validated['image'] = $path;
        }

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data'    => $category
        ], 201);
    }

    // GET /api/categories/{id}
    public function show(Category $category)
    {
        return response()->json($category->load('parent:id,name'), 200);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:75',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = $request->file('image')
                ->store('images/categories', 'public');
        }

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data'    => $category
        ], 200);
    }

    // DELETE /api/categories/{id}
    public function destroy(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
