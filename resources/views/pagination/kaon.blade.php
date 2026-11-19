{{-- Pagination styled for Kaon Ta! Used as $paginator->links('pagination.kaon'). --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <p class="text-sm text-ink-soft">
            Showing <span class="font-semibold tabular-nums text-ink">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
            of <span class="font-semibold tabular-nums text-ink">{{ $paginator->total() }}</span>
        </p>

        <ul class="flex flex-wrap items-center gap-1 text-sm font-semibold">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="block rounded px-3 py-2 text-ink-soft/60" aria-disabled="true">Previous</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="block rounded px-3 py-2 hover:bg-paper-deep">Previous</a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="block px-2 py-2 text-ink-soft">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="block min-w-9 rounded bg-board px-3 py-2 text-center tabular-nums text-chalk">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="block min-w-9 rounded px-3 py-2 text-center tabular-nums hover:bg-paper-deep" aria-label="Page {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="block rounded px-3 py-2 hover:bg-paper-deep">Next</a>
                @else
                    <span class="block rounded px-3 py-2 text-ink-soft/60" aria-disabled="true">Next</span>
                @endif
            </li>
        </ul>
    </nav>
@endif
