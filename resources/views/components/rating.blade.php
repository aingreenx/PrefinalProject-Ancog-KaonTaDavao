{{--
    <x-rating :value="4.3" :count="7" />  ->  ★★★★☆ 4.3 ★ (7 reviews)   (cards: average + count)
    <x-rating :value="4" />               ->  ★★★★☆                   (a single review)
    A count of 0 shows "No reviews yet".
--}}
@props(['value' => null, 'count' => null])

@php
    $stars = (int) round((float) $value);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex flex-wrap items-center gap-x-2 text-sm']) }}>
    @if (! is_null($count) && (int) $count === 0)
        <span class="text-stone-500">No reviews yet</span>
    @else
        <span class="tracking-tight text-amber-500" aria-hidden="true">@for ($i = 1; $i <= 5; $i++){{ $i <= $stars ? '★' : '☆' }}@endfor</span>
        @if (! is_null($count))
            <span class="font-medium text-stone-700">{{ number_format((float) $value, 1) }} ★ ({{ $count }} {{ Str::plural('review', (int) $count) }})</span>
        @else
            <span class="sr-only">{{ $value }} out of 5</span>
        @endif
    @endif
</span>
