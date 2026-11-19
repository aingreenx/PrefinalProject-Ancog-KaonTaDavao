@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-5xl font-black tracking-tight text-board">Eateries</h1>
            <p class="mt-1 text-ink-soft">Search by name or specialty, then narrow by district or feature.</p>
        </div>
    </div>

    {{-- One GET form; filters combine and keep their values. --}}
    <form method="GET" action="{{ route('eateries.index') }}" role="search"
          class="mb-8 grid grid-cols-1 gap-4 rounded-md bg-paper-deep p-4 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_auto] lg:items-end">
        <div>
            <label for="q" class="text-sm font-semibold">Search</label>
            <div class="relative">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 mt-[3px] -translate-y-1/2 text-ink-soft" />
                <input type="search" id="q" name="q" value="{{ request('q') }}" placeholder="e.g. tinola, Carinderia ni…" class="field pl-9">
            </div>
        </div>
        <div>
            <label for="district" class="text-sm font-semibold">District</label>
            <select id="district" name="district" class="field">
                <option value="">All districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) request('district') === (string) $district->id)>{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="feature" class="text-sm font-semibold">Feature</label>
            <select id="feature" name="feature" class="field">
                <option value="">All features</option>
                @foreach ($features as $feature)
                    <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>{{ $feature->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2 sm:col-span-2 lg:col-span-1">
            <button type="submit" class="btn btn-primary">Filter</button>
            @if (request()->hasAny(['q', 'district', 'feature']))
                <a href="{{ route('eateries.index') }}" class="btn btn-ghost">Clear</a>
            @endif
        </div>
    </form>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <div class="rounded-md border-[1.5px] border-dashed border-line px-6 py-12 text-center md:col-span-2 lg:col-span-3">
                <p class="font-display text-2xl font-extrabold">No eateries match your filters.</p>
                <p class="mt-2 text-ink-soft">Try a shorter search or fewer filters. <a href="{{ route('eateries.index') }}" class="font-semibold text-board underline">Show all eateries</a></p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $eateries->links('pagination.kaon') }}
    </div>
@endsection
