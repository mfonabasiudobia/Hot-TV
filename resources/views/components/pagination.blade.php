@if($items->total() > 12)
<div class="flex justify-center md:justify-end text-sm">

    <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
        <span class="opacity-60">Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{
            $items->total()
            }} data</span>

        <div class="space-x-1 flex items-center">
            @if ($items->previousPageUrl())
            <button wire:click="gotoPage({{ $items->currentPage() - 1 }})"
                class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                <i class="las la-angle-double-left"></i>
                <span>Previous</span>
            </button>
            @else
            <a class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center opacity-50" disabled>
                <i class="las la-angle-double-left"></i>
                <span>Previous</span>
            </a>
            @endif

            {{-- @foreach (range(1, $items->lastPage()) as $pageNumber)
            <button wire:click="gotoPage({{ $pageNumber }})"
                class="space-x-1 btn btn-sm bg-{{ $pageNumber == $items->currentPage() ? 'danger' : 'dark' }} rounded-xl">
                {{ $pageNumber }}
            </button>
            @endforeach --}}

            @php
            $startPage = max(1, $items->currentPage() - 2);
            $endPage = min($items->lastPage(), $startPage + 4);
            @endphp

            @if ($startPage > 1)
            <!-- Add an ellipsis if not on the first page set -->
            <span class="opacity-60">...</span>
            @endif

            @foreach (range($startPage, $endPage) as $pageNumber)
            <button wire:click="gotoPage({{ $pageNumber }})"
                class="space-x-1 btn btn-sm bg-{{ $pageNumber == $items->currentPage() ? 'danger' : 'dark' }} rounded-xl">
                {{ $pageNumber }}
            </button>
            @endforeach

            @if ($endPage < $items->lastPage())
                <!-- Add an ellipsis if not on the last page set -->
                <span class="opacity-60">...</span>
                @endif

                @if ($items->nextPageUrl())
                <button wire:click="gotoPage({{ $items->currentPage() + 1  }})"
                    class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                    <span>Next</span>
                    <i class="las la-angle-double-right"></i>
                </button>
                @else
                <a class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center opacity-50" disabled>
                    <span>Next</span>
                    <i class="las la-angle-double-right"></i>
                </a>
                @endif
        </div>
    </div>
</div>
@endIf