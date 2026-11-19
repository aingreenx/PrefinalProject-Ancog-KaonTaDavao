@extends('layouts.app')

@section('content')
    {{-- Details --}}
    <section class="rounded-xl border border-stone-200 bg-white p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-bold tracking-tight">{{ $eatery->name }}</h1>
                    @unless ($eatery->is_open)
                        <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Closed</span>
                    @endunless
                </div>
                <p class="mt-1 text-stone-600">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-medium text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
                    <span aria-hidden="true">·</span> {{ $eatery->address }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="rounded-lg border border-stone-300 px-4 py-2 text-sm font-medium hover:bg-stone-100">Edit</a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery and all its dishes, permit, and reviews?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>

        <dl class="mt-6 grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
            <div>
                <dt class="text-stone-500">Price range</dt>
                <dd class="font-semibold text-emerald-700">{{ $eatery->price_symbol }} <span class="font-normal text-stone-500">({{ ucfirst($eatery->price_range) }})</span></dd>
            </div>
            <div>
                <dt class="text-stone-500">Specialty</dt>
                <dd>{{ $eatery->specialty ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-stone-500">Rating</dt>
                <dd><x-rating :value="$eatery->reviews_avg_rating" :count="$eatery->reviews_count" /></dd>
            </div>
        </dl>

        @if ($eatery->features->isNotEmpty())
            <ul class="mt-5 flex flex-wrap gap-1.5">
                @foreach ($eatery->features as $feature)
                    <li>
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                           class="inline-block rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-medium text-orange-800 ring-1 ring-orange-200 hover:bg-orange-100">{{ $feature->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Permit --}}
        <section class="rounded-xl border border-stone-200 bg-white p-6">
            <h2 class="text-lg font-semibold">Business Permit</h2>
            @if ($eatery->permit)
                <dl class="mt-3 space-y-2 text-sm">
                    <div>
                        <dt class="text-stone-500">Permit number</dt>
                        <dd class="font-mono font-medium">{{ $eatery->permit->permit_no }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Expires on</dt>
                        <dd>{{ $eatery->permit->expires_on->format('F j, Y') }}</dd>
                    </div>
                </dl>
                @if ($eatery->permit->isExpired())
                    <p class="mt-3 font-semibold text-red-600">Permit expired</p>
                @endif
            @else
                <p class="mt-3 text-sm text-stone-500">No permit on file.</p>
            @endif
        </section>

        {{-- Dishes --}}
        <section class="rounded-xl border border-stone-200 bg-white p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold">Dishes</h2>
            <ul class="mt-3 divide-y divide-stone-100">
                @forelse ($eatery->dishes as $dish)
                    <li class="flex items-center justify-between gap-3 py-2">
                        <span>
                            {{ $dish->name }}
                            @if ($dish->is_bestseller)
                                <span class="ml-2 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">Bestseller</span>
                            @endif
                        </span>
                        <span class="font-medium tabular-nums">₱{{ number_format((float) $dish->price, 2) }}</span>
                    </li>
                @empty
                    <li class="py-2 text-sm text-stone-500">No dishes listed yet.</li>
                @endforelse
            </ul>
        </section>
    </div>

    {{-- Reviews --}}
    <section class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-stone-200 bg-white p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold">Reviews</h2>
            <ul class="mt-3 space-y-4">
                @forelse ($eatery->reviews as $review)
                    <li class="border-b border-stone-100 pb-4 last:border-0">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                <a href="{{ route('reviewers.show', $review->user) }}" class="font-medium text-orange-700 hover:underline">{{ $review->user->name }}</a>
                                <x-rating :value="$review->rating" />
                                <span class="text-sm text-stone-500">{{ $review->rating }}/5 · {{ $review->created_at->format('M j, Y') }}</span>
                            </div>
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                        <p class="mt-2 text-stone-700">{{ $review->body }}</p>
                    </li>
                @empty
                    <li class="text-sm text-stone-500">No reviews yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-stone-200 bg-white p-6">
            <h2 class="text-lg font-semibold">Write a review</h2>
            @if ($eatery->is_open)
                @if ($errors->any())
                    <div class="mt-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mt-3 space-y-4">
                    @csrf
                    <div>
                        <label for="user_id" class="block text-sm font-medium">Reviewer</label>
                        <select id="user_id" name="user_id" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">Choose a reviewer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="rating" class="block text-sm font-medium">Rating</label>
                        <select id="rating" name="rating" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">Choose a rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" @selected((string) old('rating') === (string) $i)>{{ $i }} ★</option>
                            @endfor
                        </select>
                        @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-medium">Review</label>
                        <textarea id="body" name="body" rows="4" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">{{ old('body') }}</textarea>
                        @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-orange-600 px-4 py-2 font-semibold text-white hover:bg-orange-700">Post review</button>
                </form>
            @else
                <p class="mt-3 text-stone-600">This eatery is closed. Reviews are paused.</p>
            @endif
        </div>
    </section>
@endsection
