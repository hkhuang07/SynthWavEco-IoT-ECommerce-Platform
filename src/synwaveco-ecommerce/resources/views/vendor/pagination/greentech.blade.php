@if ($paginator->hasPages())
    <nav class="greentech-pagination">
        <ul class="pagination-list">
            {{-- First Page Link --}}
            <li>
                <a href="{{ $paginator->url(1) }}" class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}" title="First Page">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>

            {{-- Previous Page Link --}}
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}" title="Previous">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination-ellipsis"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a href="{{ $url }}" class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="{{ !$paginator->hasMorePages() ? 'disabled' : '' }}" title="Next">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>

            {{-- Last Page Link --}}
            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="{{ !$paginator->hasMorePages() ? 'disabled' : '' }}" title="Last Page">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif