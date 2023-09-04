<div class="py-5 bg-black text-white space-y-5">
    <x-atoms.breadcrumb :routes="[['title' => 'Products', 'route' => null ]]" />
    <div class="container space-y-7">
        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Our Products</h2>
                <p>The Impact of Technology on the Workplace: How Technology is Changing</p>
            </header>

            <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

                @foreach ($products as $product)
                <a class="relative space-y-5 p-5 bg-dark group border border-secondary rounded-xl"
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}">
                    <img src="{{ asset('images/product/product-1.png') }}" alt="" class="rounded-lg" />

                    <div class="space-y-3">
                        <h2 class="font-semibold text-sm">Mobile Phone</h2>

                        <p>{{ Str::limit($product->name, 80)}}</p>
                    </div>

                    <footer class="flex items-center justify-between">
                        <span class="text-danger font-bold text-xl">{{ ac() . $product->price }}</span>

                        <button class="btn btn-sm btn-danger rounded-xl">Add</button>
                    </footer>
                </a>
                @endforeach

            </section>


            <div class="flex justify-center md:justify-end text-sm">
                <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
                    <span class="opacity-60">Showing 10 from 10 data</span>

                    <div class="space-x-1 flex items-center">
                        <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                            <i class="las la-angle-double-left"></i>
                            <span>Previous</span>
                        </a>

                        <a href="#" class="space-x-1 btn btn-sm bg-danger rounded-xl">
                            1
                        </a>

                        <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                            <span>Next</span>
                            <i class="las la-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @livewire("home.partials.newsletter")
</div>