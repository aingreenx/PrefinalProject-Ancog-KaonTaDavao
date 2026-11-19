@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">{{ $user->name }}</h1>
        <p class="mt-1 text-stone-600">{{ $user->reviews_count }} {{ Str::plural('review', $user->reviews_count) }} written</p>
    </div>

    <ul class="space-y-4">
        @forelse ($reviews as $review)
            <li class="rounded-xl border border-stone-200 bg-white p-5">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold text-orange-700 hover:underline">{{ $review->eatery->name }}</a>
                    <x-rating :value="$review->rating" />
                    <span class="text-sm text-stone-500">{{ $review->rating }}/5 · {{ $review->created_at->format('M j, Y') }}</span>
                </div>
                <p class="mt-2 text-stone-700">{{ $review->body }}</p>
            </li>
        @empty
            <li class="text-stone-500">No reviews written yet.</li>
        @endforelse
    </ul>
@endsection
