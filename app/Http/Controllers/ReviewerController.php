<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ReviewerController extends Controller
{
    public function show(User $user): View
    {
        $user->loadCount('reviews');

        $reviews = $user->reviews()
            ->with('eatery')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        return view('reviewers.show', [
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }
}
