<div class="py-5">
    <section class="container space-y-3">
        <h1 class="font-bold text-md">Tv Shows</h1>
        <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
             @forelse ($watchlists as $watchlist)
                <a class="relative space-y-5 p-5 bg-dark rounded-xl group hover:scale-125 transition-all"
                    href="{{ route('tv-shows.show', ['slug' => $watchlist->tvShow->slug ]) }}">
                    <img src="{{ file_path($watchlist->tvShow->thumbnail) }}" alt="" class="h-[321px] rounded-lg object-cover w-full" />

                    <div class="space-y-3">
                        <h2 class="text-center font-semibold">{{ $watchlist->tvShow->title }}</h2>

                        <div class="flex items-center justify-between opacity-60 text-sm">
                            <span>{{ view_count($watchlist->tvShow->views->count()) }} views</span>
                            <span>{{ convert_seconds_to_time($watchlist->tvShow->episodes()->sum('duration')) }}</span>
                        </div>
                    </div>

                    <span
                        class="rounded-b-lg bg-danger py-1 px-5 absolute left-1/2 transform -translate-x-1/2 top-0 whitespace-nowrap">{{
                        $watchlist->tvShow->categories[0]->name }}</span>
                </a>
                @empty
                <div
                    class="flex flex-col justify-center items-center space-y-3 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-7">
                    <h1 class="text-xl md:text-2xl font-bold">Nothing Found</h1>
                    <p>No TV Show has been added to watchlist. <a href="{{ route('tv-shows.home') }}" class="text-danger">Click here</a> to
                        continue watching</p>
                </div>

                @endforelse

            </section>

            <x-pagination :items="$watchlists" />
    </section>
</div>
