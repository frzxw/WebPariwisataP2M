<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService) {}

    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'facility'])
            ->when($request->facility_id, function ($query, $facilityId) {
                $query->where('facility_id', $facilityId);
            })
            ->approved()
            ->latest()
            ->paginate(10);

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewRequest $request)
    {
        try {
            $reviewData = array_merge($request->validated(), [
                'user_id' => $request->user()->id
            ]);

            $review = $this->reviewService->createReview($reviewData);
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully and is pending approval',
                'data' => new ReviewResource($review)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Review $review)
    {
        return new ReviewResource($review->load(['user', 'facility']));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);
        
        try {
            $review = $this->reviewService->updateReview($review, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully',
                'data' => new ReviewResource($review)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        try {
            $review->delete();
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
