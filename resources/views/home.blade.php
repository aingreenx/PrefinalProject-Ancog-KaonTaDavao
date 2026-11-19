@extends('layouts.app')

@section('content')
    <section class="mb-10">
        <h1 class="text-3xl font-bold tracking-tight">Kaon ta! Where to eat in Davao</h1>
        <p class="mt-2 max-w-2xl text-stone-600">Carinderias and eateries by district: permits, dishes, features, and reviews from residents.</p>

        <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-stone-200 bg-white p-5">
                <dt class="text-sm text-stone-500">Eateries</dt>
                <dd class="mt-1 text-3xl font-bold">{{ $eateryCount }}</dd>
            </div>
            <div class="rounded-xl border border-stone-200 bg-white p-5">
                <dt class="text-sm text-stone-500">Districts</dt>
                <dd class="mt-1 text-3xl font-bold">{{ $districtCount }}</dd>
            </div>
            <div class="rounded-xl border border-stone-200 bg-white p-5">
                <dt class="text-sm text-stone-500">Reviews</dt>
                <dd class="mt-1 text-3xl font-bold">{{ $reviewCount }}</dd>
            </div>
        </dl>
    </section>

    <section>
        <h2 class="mb-4 text-2xl font-semibold">Top Rated</h2>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @empty
                <p class="text-stone-500">No rated eateries yet.</p>
            @endforelse
        </div>
    </section>
@endsection
