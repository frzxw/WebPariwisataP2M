<?php

namespace App\Http\Controllers;

use App\Http\Resources\FacilityResource;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private SearchService $searchService) {}

    public function facilities(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
            'features' => 'nullable|array',
            'sort_by' => 'nullable|in:price_asc,price_desc,rating,latest',
        ]);

        try {
            $facilities = $this->searchService->searchFacilities($request->all());
            return FacilityResource::collection($facilities);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function suggestions(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2|max:50'
        ]);

        try {
            $suggestions = $this->searchService->getSuggestions($request->query);
            return response()->json([
                'success' => true,
                'data' => $suggestions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
