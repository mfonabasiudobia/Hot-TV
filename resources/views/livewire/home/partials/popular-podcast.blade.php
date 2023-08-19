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
                    <img src="{{ asset('images/placeholder-03.png') }}" alt="" />
                @endforeach
            </section>

        </section>
    </div>
</section>