<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => $tvShow->name, 'route' => null ]]" />
    <div class="container space-y-7">

        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">{{ $tvShow->name }}</h2>
                <p>{!! $tvShow->content !!}</p>
            </header>

            <div class="rounded-2xl px-7 hidden md:flex justify-between items-center bg-dark text-sm py-3">
                <button class="flex items-center space-x-3" wire:click="sortByTitle()">
                    <span>Shows Title</span>

                    <img src="{{ asset('svg/ic_sort.svg') }}" alt="" class="{{ $sortByTitle === "desc" ? 'rotate-180' : '' }}" />
                </button>

                <div class="flex items-center space-x-7">
                    <button wire:click="sortByTime('today')">Today</button>

                    <button wire:click="sortByTime('week')">This Week</button>

                    <button wire:click="sortByTime('month')">This Month</button>

                    <button wire:click="sortByDate()" class="flex items-center space-x-1">
                        <i class="las {{ $sortByDate === "desc" ? 'la-sort-amount-down-alt' : 'la-sort-amount-up-alt' }}  text-xl"></i>
                        <span>{{ $sortByDate === "desc" ? 'Newest' : 'Oldest' }}</span>
                    </button>
                </div>
            </div>

            <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

               @forelse ($tvShows as $show)
                   <a class="relative space-y-5 p-5 bg-dark rounded-xl group hover:scale-125 transition-all" href="{{ route('tv-shows.show', ['slug' => $show->slug ]) }}">
                        <img src="{{ file_path($show->thumbnail) }}" alt="" class="h-[321px] rounded-lg object-cover w-full" />

                        <div class="space-y-3">
                            <h2 class="text-center font-semibold">{{ $show->title }}</h2>

                            <div class="flex items-center justify-between opacity-60 text-sm">
                                <span>{{ view_count($show->views->count()) }} views</span>
                                <span>{{ convert_seconds_to_time($show->episodes()->sum('duration')) }}</span>
                            </div>
                        </div>
                        @if (\Carbon\Carbon::parse($show->release_date)->isFuture())
                            <span class="rounded-b-lg bg-danger py-1 px-5 absolute left-1/2 transform -translate-x-1/2 top-1/2 whitespace-nowrap"> Coming Soon... </span>
                        @endif

                        <span class="rounded-b-lg bg-danger py-1 px-5 absolute left-1/2 transform -translate-x-1/2 top-0 whitespace-nowrap">{{ $show->categories[0]->name }}</span>
                    </a>

                @empty
                    <div class="flex flex-col justify-center items-center space-y-3 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-7">
                        <h1 class="text-xl md:text-2xl font-bold">Nothing Found</h1>
                        <p>Sorry, nothing found. Please try again with some different keywords.</p>
                    </div>
               @endforelse

            </section>
            <x-pagination :items="$tvShows" />

        </section>
    </div>


    @livewire("home.partials.partners")


    @livewire("home.partials.newsletter")
</div>
