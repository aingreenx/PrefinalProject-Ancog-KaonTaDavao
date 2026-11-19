<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Eatery $eatery): RedirectResponse
    {
        abort(501); // Phase 4 (needs StoreReviewRequest)
    }

    public function destroy(Review $review): RedirectResponse
    {
        $eatery = $review->eatery;
        $review->delete();

        return redirect()->route('eateries.show', $eatery)->with('status', 'Review deleted.');
    }
}
