@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold tracking-tight">Districts</h1>

    <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($districts as $district)
            <li>
                <a href="{{ route('districts.show', $district) }}"
                   class="flex items-center justify-between rounded-xl border border-stone-200 bg-white p-5 transition hover:border-orange-300 hover:shadow-sm">
                    <span class="font-semibold">{{ $district->name }}</span>
                    <span class="text-sm text-stone-500">{{ $district->eateries_count }} {{ Str::plural('eatery', $district->eateries_count) }}</span>
                </a>
            </li>
        @empty
            <li class="text-stone-500">No districts yet.</li>
        @endforelse
    </ul>
@endsection
