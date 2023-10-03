<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="md:w-1/2 space-y-2">
                <h1 class="font-semibold text-xl md:text-2xl">{{ $shortcode->title }}</h1>
                <p class="text-sm">{{ $shortcode->description }}</p>
            </div>

            <a href="{{ $shortcode->button_primary_url }}" class="flex text-sm items-center space-x-1">
                <span>{{ $shortcode->button_primary_label }}</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>

        <div class="swiper recommendation">
            <div class="swiper-wrapper">
                @foreach ([1,2,3,4,5,6,7,8] as $item)
                <a href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                    class="transition-all bg-black hover:bg-white p-2 rounded-xl overflow-hidden text-dark shadow-xl swiper-slide recommendation-item-wrapper group relative">
                    <img src="{{ asset('images/placeholder-02.png') }}" alt=""
                        class="object-cover h-[284px] w-full rounded-lg" />

                    <section class="p-3 space-y-5 recommendation-item-details invisible group-hover:visible">
                        <div class="space-y-2">
                            <h2 class="text-md font-semibold">Cloak Dagger - Marvel</h2>
                            <span class="text-danger text-sm">Comedy</span>
                            <div class="opacity-60 space-x-3 text-sm">
                                <span>2019</span>
                                <span>120 Episodes</span>
                            </div>
                        </div>
                    </section>


                    <button
                        class="invisible group-hover:visible btn h-[48px] w-[48px] border rounded-2xl hover:border-danger hover:bg-danger hover:text-white text-danger absolute top-5 right-5">
                        <i class="las la-heart text-2xl"></i>
                    </button>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('header')
<style>
    /* .recommendation-item-details {
        display: none; 
    }

    .swiper-slide-active .recommendation-item-details {
        display: block; 
    } */

    /* .swiper-slide-active.recommendation-item-wrapper {
        padding: 10px;
    }

    .swiper-slide-active.recommendation-item-wrapper img {
        border-radius: 10px;
    } */
</style>
@endpush
@push('script')
<script>
    var swiper = new Swiper(".recommendation", {
          slidesPerView: 2,
          spaceBetween: 5,
          grabCursor: false,
        loop: true,
        speed: 1000,
        centeredSlides: false,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            1024: {
                slidesPerView: 5
            }
        }
        });
</script>
@endpush