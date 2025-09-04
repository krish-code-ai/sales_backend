<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    // List all categories
    public function index()
    {
        return response()->json(ItemCategory::all());
    }

    // Create a category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:item_categories,name'
        ]);

        $category = ItemCategory::create($request->only('name'));
        return response()->json($category, 201);
    }

    // Show a category
    public function show($id)
    {
        $category = ItemCategory::findOrFail($id);
        return response()->json($category);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $category = ItemCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|unique:item_categories,name,' . $id
        ]);

        $category->update($request->only('name'));
        return response()->json($category);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = ItemCategory::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
