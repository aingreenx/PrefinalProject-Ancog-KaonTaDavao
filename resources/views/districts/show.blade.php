@extends('layouts.app')

@section('content')
    <div class="mb-8 border-b border-line pb-6">
        <a href="{{ route('districts.index') }}" class="text-sm font-semibold text-ink-soft hover:text-ink">All districts</a>
        <h1 class="mt-1 font-display text-6xl font-black tracking-tight text-board">{{ $district->name }}</h1>
        {{-- reviews_count comes from the hasManyThrough relationship (District -> Eatery -> Review) --}}
        <p class="mt-2 text-lg">
            <span class="font-semibold">{{ $district->reviews_count }} {{ Str::plural('review', $district->reviews_count) }} in {{ $district->name }}</span>
            <span class="text-ink-soft">· {{ $eateries->count() }} {{ Str::plural('eatery', $eateries->count()) }}</span>
        </p>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-ink-soft">No eateries in {{ $district->name }} yet. <a href="{{ route('eateries.create') }}" class="font-semibold text-board underline">Add one</a></p>
        @endforelse
    </div>
@endsection
