
<section>
    <x-loading />
    <div class="py-5 bg-black text-white space-y-5">
        <x-atoms.breadcrumb :routes="[['title' => $product->name, 'route' => null ]]" />
        <div class="container space-y-7">
            <section class="space-y-7">
                <header class="space-y-3">
                    <h2 class="font-semibold text-xl md:text-3xl">Our Products</h2>
                    <p>The Impact of Technology on the Workplace: How Technology is Changing</p>
                </header>
                <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                    @foreach ($products as $product)
                        @php
                            $prices = getProductSalePrice($product);
                            $price = $prices['price'];
                            $oldPrice = $prices['old_price'];
                        @endphp

                        <a class="relative space-y-5 p-5 bg-dark group border border-secondary rounded-xl" href="{{ route('merchandize.show',['slug' => $product->slug ]) }}">
                            <img src="{{ file_path($product->images[0]) }}" alt="" class="rounded-lg w-full h-[280px] object-cover" />

                            <div class="space-y-3">
                                @if(isset($product->categories[0]->name))
                                <h2 class="font-semibold text-sm">{{ $product->categories[0]->name }}</h2>
                                @endIf

                                <p>{{ Str::limit($product->name, 80)}}</p>
                            </div>

                            <footer class="flex items-center justify-between">

                                    <span class="text-danger font-bold text-xl">{{ ac(). number_format($price, 2) }}</span>
                                    @if($oldPrice)
                                    /
                                    <strike class="opacity-50">{{ ac() . number_format($oldPrice)}}</strike>
                                    @endif


                                <button wire:click.prevent="addToCart({{ $product }})"
                                    class="btn btn-sm btn-danger rounded-xl">Add</button>

                            </footer>

                           @if(is_user_logged_in())
                                <button wire:click.prevent="saveToWishList({{ $product->id }})" class="rounded-md absolute top-3 right-7 w-[40px] h-[40px]
                                    {{ Botble\Ecommerce\Models\Wishlist::where('customer_id', auth()->id())->where('product_id', $product->id)->first() ? 'bg-danger shadow-xl text-white' : 'bg-white shadow-xl text-danger' }}">
                                    <i class="las la-heart"></i>
                                </button>
                           @endIf
                        </a>
                    @endforeach
                </section>
                <x-pagination :items="$products" />
            </section>
        </div>
        @livewire("home.partials.newsletter")
    </div>
</section>
