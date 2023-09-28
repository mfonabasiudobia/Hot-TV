<div class="py-16">
    <section class="container">
        {{-- wishlists --}}

        @if($wishlists->total() > 0)
        
       <section>
        
        <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach ($wishlists as $wishlist)
        <a class="relative space-y-5 p-5 bg-dark group border border-secondary rounded-xl"
            href="{{ route('merchandize.show',['slug' => $wishlist->product->slug ]) }}">
            <img src="{{ file_path($wishlist->product->images[0]) }}" alt="" class="rounded-lg w-full h-[280px] object-cover" />
        
            <div class="space-y-3">
                @if(isset($wishlist->product->categories[0]->name))
                <h2 class="font-semibold text-sm">{{ $wishlist->product->categories[0]->name }}</h2>
                @endIf
        
                <p>{{ Str::limit($wishlist->product->name, 80)}}</p>
            </div>
        
            <footer class="flex items-center justify-between">
                <div>
                    <span class="text-danger font-bold text-xl">
                        {{ ac() . number_format($wishlist->product->price)}}
                    </span>
                    @if($wishlist->product->sale_price > 0)
                    /
                    <strike class="opacity-50">{{ ac() . number_format($wishlist->product->sale_price)}}</strike>
                    @endIf
                </div>
        
                <button wire:click.prevent="addToCart({{ $wishlist->product }})" class="btn btn-sm btn-danger rounded-xl">Add</button>
            </footer>
        
            @auth
            <button wire:click.prevent="saveToWishList({{ $wishlist->product->id }})"
                class="rounded-md absolute top-3 right-7 w-[40px] h-[40px] 
                                        {{ Botble\Ecommerce\Models\Wishlist::where('customer_id', auth()->id())->where('product_id', $wishlist->product->id)->first() ? 'bg-danger shadow-xl text-white' : 'bg-white shadow-xl text-danger' }}">
                <i class="las la-heart"></i>
            </button>
            @endauth
        </a>
        @endforeach
        </section>
        
        </section>
        
        <x-pagination :items="$wishlists" />
       </section>

        @else
            <div
                class="flex flex-col justify-center items-center space-y-3 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-7">
                <h1 class="text-xl md:text-2xl font-bold">Nothing Found</h1>
                <p>No Item has been added to wishlist. <a href="{{ route('merchandize.home') }}" class="text-danger">Click here</a> to continue shopping</p>
            </div>
        @endIf
    </section>
</div>
