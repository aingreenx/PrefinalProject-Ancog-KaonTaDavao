@extends('layouts.app')

@section('content')
    <section class="grid gap-10 border-b border-line pb-12 pt-2 md:grid-cols-[1.5fr_1fr] md:items-end">
        <div>
            <h1 class="font-display text-6xl font-black leading-[0.88] tracking-tight text-board sm:text-8xl">Asa ta mokaon karon?</h1>
            <p class="mt-5 max-w-[52ch] text-lg leading-relaxed text-ink-soft">
                Where do we eat today? A district-by-district guide to Davao's carinderias: tinola in Poblacion,
                kinilaw near Agdao, a durian shake after class.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ route('eateries.index') }}" class="btn btn-primary">Browse eateries <x-icon name="arrow-right" /></a>
                <a href="{{ route('districts.index') }}" class="btn btn-ghost">Pick a district</a>
            </div>
        </div>

        <p class="text-xl leading-snug text-ink md:border-l md:border-line md:pl-8">
            <span class="font-display text-5xl font-black tabular-nums text-sili">{{ $eateryCount }}</span>
            {{ Str::plural('eatery', $eateryCount) }} across
            <span class="font-display text-5xl font-black tabular-nums text-sili">{{ $districtCount }}</span>
            {{ Str::plural('district', $districtCount) }}, with
            <span class="font-display text-5xl font-black tabular-nums text-sili">{{ $reviewCount }}</span>
            {{ Str::plural('review', $reviewCount) }} from residents.
        </p>
    </section>

    <section class="pt-12">
        <div class="mb-6 flex flex-wrap items-baseline justify-between gap-2">
            <h2 class="font-display text-4xl font-extrabold tracking-tight">Top Rated</h2>
            <p class="text-sm text-ink-soft">Highest average rating, from eateries with at least one review.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @empty
                <p class="text-ink-soft">No eatery has a review yet. Open one and be the first to rate it.</p>
            @endforelse
        </div>
    </section>
@endsection
