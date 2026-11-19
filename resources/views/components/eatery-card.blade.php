{{-- Expects an Eatery loaded with Eatery::withCardData() (district, features, reviews_count, reviews_avg_rating). --}}
@props(['eatery'])

<article {{ $attributes->class([
    'group relative flex flex-col rounded-md border-[1.5px] p-5 transition duration-300',
    'border-line bg-[#fffaf0] hover:-translate-y-0.5 hover:border-ink/40 hover:shadow-[0_10px_24px_-14px_rgb(31_42_30/0.45)]' => $eatery->is_open,
    'border-dashed border-[#c4b28c] bg-paper' => ! $eatery->is_open,
]) }}>
    <div class="flex items-start justify-between gap-3">
        <h3 class="font-display text-2xl font-extrabold leading-[1.05] tracking-tight text-ink">
            <a href="{{ route('eateries.show', $eatery) }}" class="decoration-luyang decoration-2 hover:underline">{{ $eatery->name }}</a>
        </h3>
        <span class="shrink-0 -rotate-3 rounded-sm bg-paper-deep px-2 py-0.5 text-base font-extrabold tracking-wider text-sili"
              title="{{ ucfirst($eatery->price_range) }}">{{ $eatery->price_symbol }}</span>
    </div>

    <p class="mt-2 flex items-center gap-1.5 text-sm">
        <x-icon name="map-pin" class="size-3.5 text-ink-soft" />
        <a href="{{ route('districts.show', $eatery->district) }}" class="font-semibold text-board underline decoration-line hover:decoration-board">{{ $eatery->district->name }}</a>
    </p>

    @if ($eatery->specialty)
        <p class="mt-3 text-[0.9375rem] text-ink-soft">Known for <span class="font-semibold text-ink">{{ $eatery->specialty }}</span></p>
    @endif

    @if ($eatery->features->isNotEmpty())
        <ul class="mt-4 flex flex-wrap gap-1.5">
            @foreach ($eatery->features as $feature)
                <li><a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="tape hover:brightness-95">{{ $feature->name }}</a></li>
            @endforeach
        </ul>
    @endif

    <div class="mt-auto pt-5">
        <div class="border-t border-dashed border-line pt-3">
            <x-rating :value="$eatery->reviews_avg_rating" :count="$eatery->reviews_count" />
        </div>
    </div>

    @unless ($eatery->is_open)
        <span class="stamp absolute right-4 bottom-12 bg-paper text-sili">Closed</span>
    @endunless
</article>
