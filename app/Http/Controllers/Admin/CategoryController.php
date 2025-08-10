<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(Request $request)
    {
        $categories = Category::withCount('facilities')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Category $category)
    {
        return new CategoryResource($category->load(['facilities']));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->updateCategory($category, $request->validated());
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->facilities()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with existing facilities'
                ], 422);
            }

            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
