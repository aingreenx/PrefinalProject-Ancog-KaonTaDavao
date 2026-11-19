{{--
    <x-rating :value="4.3" :count="7" />  ->  five stars + "4.3 ★ (7 reviews)"   (average with count)
    <x-rating :value="4" />               ->  five stars + "4/5"                 (one review)
    A count of 0 shows "No reviews yet".
--}}
@props(['value' => null, 'count' => null])

@php
    $stars = (int) round((float) $value);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex flex-wrap items-center gap-x-2 gap-y-1 text-sm']) }}>
    @if (! is_null($count) && (int) $count === 0)
        <span class="italic text-ink-soft">No reviews yet</span>
    @else
        <span class="inline-flex text-luyang" aria-hidden="true">
            @for ($i = 1; $i <= 5; $i++)
                <x-icon :name="$i <= $stars ? 'star' : 'star-empty'" @class(['size-4', 'text-line' => $i > $stars]) />
            @endfor
        </span>
        @if (! is_null($count))
            <span class="font-semibold tabular-nums text-ink">{{ number_format((float) $value, 1) }} ★ ({{ $count }} {{ Str::plural('review', (int) $count) }})</span>
        @else
            <span class="font-semibold tabular-nums text-ink-soft">{{ $value }}/5</span>
        @endif
    @endif
</span>
