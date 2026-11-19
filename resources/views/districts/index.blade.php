@extends('layouts.app')

@section('content')
    <h1 class="font-display text-5xl font-black tracking-tight text-board">Districts</h1>
    <p class="mt-1 text-ink-soft">Every district in the guide and how many eateries it has.</p>

    <ul class="mt-8 max-w-3xl border-t border-line">
        @forelse ($districts as $district)
            <li class="border-b border-line">
                <a href="{{ route('districts.show', $district) }}" class="group flex items-baseline gap-4 py-4">
                    <span class="font-display text-3xl font-extrabold tracking-tight transition-colors group-hover:text-sili sm:text-4xl">{{ $district->name }}</span>
                    <span class="flex-1 translate-y-[-0.3em] border-b-2 border-dotted border-line" aria-hidden="true"></span>
                    <span class="shrink-0 font-semibold tabular-nums text-ink-soft">{{ $district->eateries_count }} {{ Str::plural('eatery', $district->eateries_count) }}</span>
                    <x-icon name="arrow-right" class="size-4 self-center text-ink-soft transition-transform group-hover:translate-x-1 group-hover:text-sili" />
                </a>
            </li>
        @empty
            <li class="py-6 text-ink-soft">No districts yet.</li>
        @endforelse
    </ul>
@endsection
