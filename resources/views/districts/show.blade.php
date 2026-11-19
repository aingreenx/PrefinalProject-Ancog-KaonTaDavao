@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">{{ $district->name }}</h1>
        {{-- reviews_count comes from the hasManyThrough relationship (District -> Eatery -> Review) --}}
        <p class="mt-1 text-stone-600">{{ $district->reviews_count }} {{ Str::plural('review', $district->reviews_count) }} in {{ $district->name }}</p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-stone-500">No eateries in this district yet.</p>
        @endforelse
    </div>
@endsection
