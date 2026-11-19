@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-bold tracking-tight">Eateries</h1>
        <a href="{{ route('eateries.create') }}" class="rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">Add Eatery</a>
    </div>

    {{-- One GET form; filters combine and keep their values. --}}
    <form method="GET" action="{{ route('eateries.index') }}" class="mb-8 grid grid-cols-1 gap-3 rounded-xl border border-stone-200 bg-white p-4 md:grid-cols-4">
        <div>
            <label for="q" class="block text-sm font-medium text-stone-600">Search</label>
            <input type="search" id="q" name="q" value="{{ request('q') }}" placeholder="Name or specialty"
                   class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
        </div>
        <div>
            <label for="district" class="block text-sm font-medium text-stone-600">District</label>
            <select id="district" name="district" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                <option value="">All districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) request('district') === (string) $district->id)>{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="feature" class="block text-sm font-medium text-stone-600">Feature</label>
            <select id="feature" name="feature" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                <option value="">All features</option>
                @foreach ($features as $feature)
                    <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>{{ $feature->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="rounded-lg bg-stone-800 px-4 py-2 text-sm font-semibold text-white hover:bg-stone-900">Filter</button>
            <a href="{{ route('eateries.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100">Clear</a>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-stone-500 md:col-span-2 lg:col-span-3">No eateries match your filters.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $eateries->links() }}
    </div>
@endsection
