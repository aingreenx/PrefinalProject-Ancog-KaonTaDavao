@extends('layouts.app')

@section('content')
    {{-- Signboard --}}
    <section class="border-b border-line pb-8">
        <div class="flex flex-wrap items-start justify-between gap-x-6 gap-y-4">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <h1 class="font-display text-5xl font-black leading-[0.95] tracking-tight text-board sm:text-6xl">{{ $eatery->name }}</h1>
                    @unless ($eatery->is_open)
                        <span class="stamp text-base text-sili">Closed</span>
                    @endunless
                </div>
                <p class="mt-3 flex flex-wrap items-center gap-x-2 gap-y-1 text-ink-soft">
                    <x-icon name="map-pin" class="text-ink-soft" />
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-semibold text-board underline decoration-line hover:decoration-board">{{ $eatery->district->name }}</a>
                    <span class="hidden sm:inline" aria-hidden="true">·</span>
                    <span class="basis-full sm:basis-auto">{{ $eatery->address }}</span>
                </p>
            </div>

            <div class="flex shrink-0 gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="btn btn-ghost"><x-icon name="pencil" />Edit</a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery? Its permit, dishes, and reviews will be removed too.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><x-icon name="trash" />Delete</button>
                </form>
            </div>
        </div>

        <dl class="mt-6 flex flex-wrap items-center gap-x-8 gap-y-4">
            <div class="flex items-center gap-3">
                <dt class="sr-only">Price range</dt>
                <dd class="-rotate-3 rounded-sm bg-paper-deep px-2.5 py-0.5 text-xl font-extrabold tracking-wider text-sili">{{ $eatery->price_symbol }}</dd>
                <span class="text-sm text-ink-soft">{{ ucfirst($eatery->price_range) }}</span>
            </div>
            @if ($eatery->specialty)
                <div>
                    <dt class="sr-only">Specialty</dt>
                    <dd class="text-ink-soft">Known for <span class="font-semibold text-ink">{{ $eatery->specialty }}</span></dd>
                </div>
            @endif
            <div>
                <dt class="sr-only">Rating</dt>
                <dd><x-rating :value="$eatery->reviews_avg_rating" :count="$eatery->reviews_count" class="text-[0.9375rem]" /></dd>
            </div>
        </dl>

        @if ($eatery->features->isNotEmpty())
            <ul class="mt-5 flex flex-wrap gap-2" aria-label="Features">
                @foreach ($eatery->features as $feature)
                    <li><a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="tape text-sm hover:brightness-95">{{ $feature->name }}</a></li>
                @endforeach
            </ul>
        @endif
    </section>

    <div class="mt-10 grid grid-cols-1 items-start gap-8 lg:grid-cols-[1.6fr_1fr]">
        {{-- Pisara: the chalkboard menu --}}
        <section class="rounded-md bg-board p-6 text-chalk shadow-[inset_0_0_0_6px_#142a1f,0_14px_28px_-18px_rgb(20_42_31/0.8)] sm:p-8" aria-labelledby="dishes-heading">
            <h2 id="dishes-heading" class="font-hand text-3xl text-luyang">Dishes</h2>
            <ul class="mt-5 space-y-4">
                @forelse ($eatery->dishes as $dish)
                    <li class="flex items-baseline gap-3">
                        <span class="font-hand text-xl leading-snug sm:text-2xl">{{ $dish->name }}</span>
                        @if ($dish->is_bestseller)
                            <span class="shrink-0 -rotate-2 rounded-sm bg-sili px-1.5 py-px text-xs font-bold uppercase tracking-wider text-white">Bestseller</span>
                        @endif
                        <span class="leader" aria-hidden="true"></span>
                        <span class="shrink-0 font-hand text-xl tabular-nums text-luyang sm:text-2xl">₱{{ number_format((float) $dish->price, 2) }}</span>
                    </li>
                @empty
                    <li class="font-hand text-xl text-chalk-soft">No dishes on the board yet.</li>
                @endforelse
            </ul>
        </section>

        {{-- Permit posted on the wall --}}
        <section class="rotate-[0.6deg] border border-line bg-[#fffdf6] p-1.5 shadow-[0_10px_22px_-14px_rgb(31_42_30/0.5)]" aria-labelledby="permit-heading">
            <div class="border-[3px] border-double border-ink/50 px-5 py-6 text-center">
                <x-icon name="badge" class="mx-auto size-7 text-board" />
                <h2 id="permit-heading" class="mt-2 font-display text-xl font-extrabold uppercase tracking-[0.14em]">Business Permit</h2>
                @if ($eatery->permit)
                    <dl class="mt-4 space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Permit number</dt>
                            <dd class="font-display text-3xl font-extrabold tabular-nums tracking-wide">{{ $eatery->permit->permit_no }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expires on</dt>
                            <dd class="font-semibold">{{ $eatery->permit->expires_on->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                    @if ($eatery->permit->isExpired())
                        <p class="mt-4"><span class="stamp text-base text-sili">Permit expired</span></p>
                    @endif
                @else
                    <p class="mt-4 text-ink-soft">No permit on file.</p>
                @endif
            </div>
        </section>
    </div>

    {{-- Reviews --}}
    <div class="mt-12 grid grid-cols-1 items-start gap-8 lg:grid-cols-[1.6fr_1fr]">
        <section aria-labelledby="reviews-heading">
            <h2 id="reviews-heading" class="font-display text-3xl font-extrabold tracking-tight">Reviews</h2>
            <ul class="mt-4 divide-y divide-dashed divide-line border-y border-dashed border-line">
                @forelse ($eatery->reviews as $review)
                    <li class="py-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                <a href="{{ route('reviewers.show', $review->user) }}" class="font-bold text-board underline decoration-line hover:decoration-board">{{ $review->user->name }}</a>
                                <x-rating :value="$review->rating" />
                                <time datetime="{{ $review->created_at->toDateString() }}" class="text-sm text-ink-soft">{{ $review->created_at->format('M j, Y') }}</time>
                            </div>
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded px-2 py-1 text-sm font-semibold text-sili hover:bg-sili/10">
                                    <x-icon name="trash" class="size-3.5" />Delete
                                </button>
                            </form>
                        </div>
                        <p class="mt-2 max-w-[65ch] leading-relaxed">{{ $review->body }}</p>
                    </li>
                @empty
                    <li class="py-6 text-ink-soft">No reviews yet. Be the first to say if it's lami.</li>
                @endforelse
            </ul>
        </section>

        <section class="rounded-md bg-paper-deep p-6" aria-labelledby="write-heading">
            <h2 id="write-heading" class="flex items-center gap-2 font-display text-2xl font-extrabold tracking-tight">
                <x-icon name="message" class="size-5 text-board" />Write a review
            </h2>

            @if ($eatery->is_open)
                @if ($errors->any())
                    <div class="mt-4 flex gap-3 rounded-md bg-sili/10 px-4 py-3 text-sm text-sili-deep" role="alert">
                        <x-icon name="alert" class="mt-0.5 size-4" />
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="user_id" class="text-sm font-semibold">Reviewer</label>
                        <select id="user_id" name="user_id" class="field" @error('user_id') aria-invalid="true" aria-describedby="user_id-error" @enderror>
                            <option value="">Choose a reviewer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p id="user_id-error" class="mt-1 text-sm font-medium text-sili">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="rating" class="text-sm font-semibold">Rating</label>
                        <select id="rating" name="rating" class="field" @error('rating') aria-invalid="true" aria-describedby="rating-error" @enderror>
                            <option value="">Choose a rating</option>
                            @foreach ([5 => '5 – Lami kaayo', 4 => '4 – Lami', 3 => '3 – Okay ra', 2 => '2 – Kulang', 1 => '1 – Dili lami'] as $value => $label)
                                <option value="{{ $value }}" @selected((string) old('rating') === (string) $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('rating') <p id="rating-error" class="mt-1 text-sm font-medium text-sili">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="body" class="text-sm font-semibold">Review</label>
                        <textarea id="body" name="body" rows="4" class="field" placeholder="What did you order? Would you come back?"
                                  @error('body') aria-invalid="true" aria-describedby="body-error" @enderror>{{ old('body') }}</textarea>
                        @error('body') <p id="body-error" class="mt-1 text-sm font-medium text-sili">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Post review</button>
                </form>
            @else
                <p class="mt-4 -rotate-1 rounded-sm bg-[#fffdf6] px-4 py-5 text-center font-hand text-xl leading-snug text-sili shadow-[0_6px_14px_-10px_rgb(31_42_30/0.5)]">This eatery is closed. Reviews are paused.</p>
            @endif
        </section>
    </div>
@endsection
