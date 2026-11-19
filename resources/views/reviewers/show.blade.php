@extends('layouts.app')

@section('content')
    <div class="mb-8 border-b border-line pb-6">
        <h1 class="font-display text-6xl font-black tracking-tight text-board">{{ $user->name }}</h1>
        <p class="mt-2 text-lg font-semibold">{{ $user->reviews_count }} {{ Str::plural('review', $user->reviews_count) }} written</p>
    </div>

    <ul class="max-w-3xl space-y-4">
        @forelse ($reviews as $review)
            <li class="rounded-md border-[1.5px] border-line bg-[#fffaf0] p-5">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <a href="{{ route('eateries.show', $review->eatery) }}" class="font-display text-2xl font-extrabold tracking-tight text-board underline decoration-line hover:decoration-board">{{ $review->eatery->name }}</a>
                    <x-rating :value="$review->rating" />
                    <time datetime="{{ $review->created_at->toDateString() }}" class="text-sm text-ink-soft">{{ $review->created_at->format('M j, Y') }}</time>
                </div>
                <p class="mt-2 max-w-[65ch] leading-relaxed">{{ $review->body }}</p>
            </li>
        @empty
            <li class="text-ink-soft">{{ $user->name }} hasn't written a review yet.</li>
        @endforelse
    </ul>
@endsection
