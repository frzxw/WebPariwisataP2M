<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function createReview(array $data): Review
    {
        $reviewData = [
            'user_id' => $data['user_id'],
            'facility_id' => $data['facility_id'],
            'booking_id' => $data['booking_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'images' => $data['images'] ?? [],
            'is_approved' => false, // Reviews need approval
        ];

        $review = Review::create($reviewData);

        // Update facility rating
        $review->facility->updateRating();

        return $review;
    }

    public function updateReview(Review $review, array $data): Review
    {
        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'images' => $data['images'] ?? $review->images,
        ]);

        // Update facility rating
        $review->facility->updateRating();

        return $review;
    }

    public function approveReview(Review $review): Review
    {
        $review->update(['is_approved' => true]);
        return $review;
    }
}
