@php
    $links = [
        ['route' => 'home', 'label' => 'Home', 'active' => 'home'],
        ['route' => 'eateries.index', 'label' => 'Eateries', 'active' => 'eateries.index'],
        ['route' => 'districts.index', 'label' => 'Districts', 'active' => 'districts.*'],
        ['route' => 'eateries.create', 'label' => 'Add Eatery', 'active' => 'eateries.create'],
    ];
@endphp

<nav aria-label="Main">
    <ul class="flex flex-wrap gap-1 text-sm font-medium">
        @foreach ($links as $link)
            <li>
                <a href="{{ route($link['route']) }}"
                   @class([
                       'rounded-md px-3 py-1.5 transition',
                       'bg-white text-orange-700' => request()->routeIs($link['active']),
                       'text-orange-50 hover:bg-orange-500' => ! request()->routeIs($link['active']),
                   ])>{{ $link['label'] }}</a>
            </li>
        @endforeach
    </ul>
</nav>
