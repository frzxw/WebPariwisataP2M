<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()
            ->withCount('facilities')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category->load(['facilities' => function($query) {
            $query->available()->with('category')->latest();
        }]));
    }
}
