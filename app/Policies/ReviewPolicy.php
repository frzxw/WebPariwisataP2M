<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function view(User $user, Review $review): bool
    {
        return $review->is_approved || $user->id === $review->user_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create reviews
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id && !$review->is_approved;
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }

    public function approve(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }
}
