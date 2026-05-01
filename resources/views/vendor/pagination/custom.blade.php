@if ($paginator->hasPages())
    <ul class="pagination">
        <li class="page-item @if ($paginator->hasMorePages()) disabled @endif">
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link page-text">
                Previous
            </a>
        </li>
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item @if ($page == $paginator->currentPage()) active @endif">
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach
        <li class="page-item @if (!$paginator->onFirstPage()) disabled @endif">
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link page-text">
                Next
            </a>
        </li>
    </ul>
@endif
