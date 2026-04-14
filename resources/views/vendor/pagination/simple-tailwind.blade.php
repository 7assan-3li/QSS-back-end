@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-var(--glass-border) bg-[var(--glass-bg)] border border-var(--glass-border) cursor-default leading-5 rounded-md dark:text-var(--glass-border) dark:border-var(--glass-border) whitespace-nowrap inline-flex items-center justify-center">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-var(--glass-border) bg-[var(--glass-bg)] border border-var(--glass-border) leading-5 rounded-md hover:text-var(--glass-border) focus:outline-none focus:ring ring-var(--glass-border) focus:border-blue-300 active:bg-gray-100 active:text-var(--glass-border) transition ease-in-out duration-150 dark:border-var(--glass-border) dark:text-var(--glass-border) dark:focus:border-blue-700 dark:active:bg-var(--glass-border) dark:active:text-var(--glass-border)">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-var(--glass-border) bg-[var(--glass-bg)] border border-var(--glass-border) leading-5 rounded-md hover:text-var(--glass-border) focus:outline-none focus:ring ring-var(--glass-border) focus:border-blue-300 active:bg-gray-100 active:text-var(--glass-border) transition ease-in-out duration-150 dark:border-var(--glass-border) dark:text-var(--glass-border) dark:focus:border-blue-700 dark:active:bg-var(--glass-border) dark:active:text-var(--glass-border)">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-var(--glass-border) bg-[var(--glass-bg)] border border-var(--glass-border) cursor-default leading-5 rounded-md dark:text-var(--glass-border) dark:border-var(--glass-border) whitespace-nowrap inline-flex items-center justify-center">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
