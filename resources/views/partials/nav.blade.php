@php
    $links = [
        ['route' => 'home', 'label' => 'Home', 'active' => 'home'],
        ['route' => 'eateries.index', 'label' => 'Eateries', 'active' => ['eateries.index', 'eateries.show', 'eateries.edit']],
        ['route' => 'districts.index', 'label' => 'Districts', 'active' => 'districts.*'],
    ];
@endphp

<nav aria-label="Main">
    <ul class="flex flex-wrap items-center gap-x-1 gap-y-2 text-[0.9375rem] font-semibold">
        @foreach ($links as $link)
            @php($isActive = request()->routeIs($link['active']))
            <li>
                <a href="{{ route($link['route']) }}" @if ($isActive) aria-current="page" @endif
                   @class([
                       'block rounded px-3 py-1.5 transition-colors',
                       'text-luyang underline decoration-2 underline-offset-[0.4em]' => $isActive,
                       'text-chalk-soft hover:bg-board-deep hover:text-chalk' => ! $isActive,
                   ])>{{ $link['label'] }}</a>
            </li>
        @endforeach
        <li class="ml-1">
            <a href="{{ route('eateries.create') }}" @if (request()->routeIs('eateries.create')) aria-current="page" @endif
               class="inline-flex items-center gap-1.5 rounded bg-luyang px-3 py-1.5 font-bold text-ink transition hover:bg-[#f0b434]">
                <x-icon name="plus" class="size-4" />Add Eatery
            </a>
        </li>
    </ul>
</nav>
