<nav aria-label="Pagination Navigation">
    <ul class="inline-flex -space-x-px text-sm">
        <li>
            @if ($items->onFirstPage())
                <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-400 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
            @endif
        </li>

        @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
            <li>
                @if ($page === $items->currentPage())
                    <a href="{{ $url }}" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 rounded-none">
                        {{ $page }}
                    </a>
                @else
                    <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                        {{ $page }}
                    </a>
                @endif
            </li>
        @endforeach

        <li>
            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
            @else
                <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-white border border-e-0 border-gray-300 rounded-e-lg cursor-not-allowed">Next</span>
            @endif
        </li>
    </ul>
</nav>