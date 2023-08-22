<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <section class="grid md:grid-cols-2 gap-10">

            <section class="space-y-10">
                <header class="space-y-3">
                    <h1 class="font-semibold text-xl md:text-3xl">Popular Podcasts</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore</p>
                </header>


                <img src="{{ asset('images/featured.png') }}" alt="" />

            </section>


            <section class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ([1,2,3,4,5,6] as $item)
                    <div class="relative h-[250px] overflow-hidden rounded-2xl" style="background-image: url('{{ asset('images/placeholder-03.png') }}');">
                        <a href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                            class="absolute top-0 bottom-0 m-auto left-0 right-0 w-[50px] h-[50px]">
                            <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                        </a>
                    </div>
                @endforeach
            </section>

        </section>
    </div>
</section>