<section>
    <x-loading />
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
                        href="{{ route('merchandize.show',['slug' => $product->slug ]) }}">
                        <img src="{{ file_path($product->images[0]) }}" alt=""
                            class="rounded-lg w-full h-[280px] object-cover" />
    
                        <div class="space-y-3">
                            @if(isset($product->categories[0]->name))
                            <h2 class="font-semibold text-sm">{{ $product->categories[0]->name }}</h2>
                            @endIf
    
                            <p>{{ Str::limit($product->name, 80)}}</p>
                        </div>
    
                        <footer class="flex items-center justify-between">
                            <div>
                                <span class="text-danger font-bold text-xl">{{ ac() . number_format($product->price)
                                    }}</span>
                            </div>
    
                            <button wire:click.prevent="addToCart({{ $product }})"
                                class="btn btn-sm btn-danger rounded-xl">Add</button>
                        </footer>
                    </a>
                    @endforeach
    
                </section>
    
    
                <x-pagination :items="$products" />
            </section>
        </div>
    
        @livewire("home.partials.newsletter")
    </div>
</section>