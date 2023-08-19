<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex items-center justify-between">
            <h1 class="font-semibold text-xl md:text-2xl">Pedicab Streams</h1>
            <a href="#" class="flex text-sm">
                <span>View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>

        <div class="grid grid-cols-3 gap-5">
                @foreach ([1,2,3, 4, 5, 6] as $item)
                    <section
                        class="shadow-xl">
                        <img src="{{ asset('images/stream-02.png') }}" alt="" class="object-cover" />
                    </section>
                @endforeach
        </div>
    </div>
</section>