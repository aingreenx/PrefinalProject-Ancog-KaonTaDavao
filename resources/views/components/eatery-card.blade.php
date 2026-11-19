{{-- Expects an Eatery loaded with Eatery::withCardData() (district, features, reviews_count, reviews_avg_rating). --}}
@props(['eatery'])

<article {{ $attributes->merge(['class' => 'flex flex-col rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md']) }}>
    <div class="flex items-start justify-between gap-3">
        <h3 class="text-lg font-semibold leading-snug">
            <a href="{{ route('eateries.show', $eatery) }}" class="hover:text-orange-700 hover:underline">{{ $eatery->name }}</a>
        </h3>
        @unless ($eatery->is_open)
            <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Closed</span>
        @endunless
    </div>

    <p class="mt-1 text-sm text-stone-600">
        <a href="{{ route('districts.show', $eatery->district) }}" class="font-medium text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
        <span aria-hidden="true">·</span>
        <span class="font-semibold text-emerald-700" title="{{ ucfirst($eatery->price_range) }}">{{ $eatery->price_symbol }}</span>
    </p>

    @if ($eatery->specialty)
        <p class="mt-2 text-sm"><span class="text-stone-500">Specialty:</span> {{ $eatery->specialty }}</p>
    @endif

    @if ($eatery->features->isNotEmpty())
        <ul class="mt-3 flex flex-wrap gap-1.5">
            @foreach ($eatery->features as $feature)
                <li>
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                       class="inline-block rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-medium text-orange-800 ring-1 ring-orange-200 hover:bg-orange-100">{{ $feature->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <x-rating :value="$eatery->reviews_avg_rating" :count="$eatery->reviews_count" class="mt-auto pt-4" />
</article>
