<div class="py-5 bg-black text-white md:space-y-5">
    <x-atoms.breadcrumb :routes="[
        ['title' => 'Products', 'route' => route('merchandize.home')],
        ['title' =>  $product->name, 'route' => null]
    ]" />
    <div class="container space-y-7 md:py-7" x-data="{ quantity : 0 }">

        <section class="grid md:grid-cols-3 gap-10 py-10">
            <section class="relative overflow-hidden" wire:ignore>
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ file_path($image) }}" class="h-[250px] md:h-[500px] w-full object-cover" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div class="swiper-slide h-[100px] w-[100px] py-2">
                                <img src="{{ file_path($image) }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="md:col-span-2 space-y-7">
                <header class="space-y-7">
                    <h1 class="font-semibold text-xl md:text-3xl">{{ $product->name }}</h1>

                    <section class="flex items-center space-x-5">
                       <div>
                            <span class="text-danger font-bold text-3xl">{{ ac(). number_format($product->price) }}</span>
                            @if($product->sale_price > 0)
                            /
                            <strike class="opacity-50">{{ ac() . number_format($product->sale_price)}}</strike>
                            @endIf
                       </div>
                        <span>({{ $product->quantity }} Units In stock)</span>
                    </section>
                </header>

                <section>
                    {!! $product->description !!}
                </section>

                <div class="flex items-center space-x-2">
                    <div class="flex items-center border px-1 rounded-sm">
                        <span class="text-xl font-bold px-7 w-[50px]" x-text="quantity">0</span>
                        <div class="flex flex-col">
                            <button class="btn px-3" x-on:click="quantity += 1">
                                <i class="las la-angle-up text-xs"></i>
                            </button>
                            <button class="btn px-3" x-on:click="quantity -= quantity <= 0 ? 0 : 1">
                                <i class="las la-angle-down text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {{-- <button class="btn btn-xl btn-danger">Add To Cart</button> --}}

                    <x-atoms.loading-button 
                        text="Add To Cart" 
                        target="addToCart" 
                        x-on:click="$wire.addToCart({{ $product }}, quantity)" 
                        class="btn btn-xl btn-danger" 
                    />

                    @if(is_user_logged_in())
                        <x-atoms.loading-button 
                            text="{{ Botble\Ecommerce\Models\Wishlist::where('customer_id', auth()->id())->where('product_id', $product->id)->first() ? 'Remove From Wishlist' : 'Add To Wishlist' }}" 
                            target="saveToWishList" 
                            x-on:click="$wire.saveToWishList({{ $product->id }})"
                            class="btn btn-xl btn-danger" 
                        />
                    @endIf

                </div>

                <ul class="space-y-2">
                    <li>SKU: {{ $product->sku }}</li>
                    <li>Categories: {{ $product->categories->pluck('name')->join(',', ' and ') }}</li>
                    <li>Tags: Printer , IT {{ $product->tags->pluck('name')->join(',', ' and ') }}</li>
                </ul>

            </section>
        </section>



     

        <hr />

    <section x-data="{ tab : 1 }" class="space-y-7">
        <nav class="flex items-center space-x-5 justify-center">
            <button 
            :class="tab == 1 ? 'bg-danger bg-opacity-50 text-danger' : ''"
            class="btn btn-sm text-xl font-semibold" 
            x-on:click="tab = 1">
                Description
            </button>
            <button 
                :class="tab == 2 ? 'bg-danger bg-opacity-50 text-danger' : ''"
                class="btn btn-sm text-xl font-semibold" 
                x-on:click="tab = 2">
                Reviews (2)
            </button>
        </nav>
        
        <section x-show="tab == 1" class="min-h-[20vh]">
            {!! BaseHelper::clean($product->content) !!}
        </section>

        <section x-show="tab == 2" class="min-h-[20vh]">
            Reviews
        </section>
    </section>

    </div>

    @livewire("home.partials.newsletter")

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
              spaceBetween: 10,
              slidesPerView: 4,
              freeMode: true,
              watchSlidesProgress: true,
            });
            var swiper2 = new Swiper(".mySwiper2", {
              spaceBetween: 10,
              navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
              },
              thumbs: {
                swiper: swiper,
              },
            });
        </script>
    @endpush

    @push('header')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

        <style>
            .swiper-button-prev,
            .swiper-button-next {
            color: #FF0207; /* Change to your desired color */
            }
        </style>
    @endpush
</div>