<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex items-center justify-between">
            <div class="md:w-1/2 space-y-2">
                <h1 class="font-semibold text-xl md:text-2xl">Recommended Tv Shows</h1>
                <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua</p>
            </div>

            <a href="#" class="flex text-sm">
                <span>View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>

        <div class="swiper recommendation">
            <div class="swiper-wrapper">
                @foreach ([1,2,3,4,5,6,7,8] as $item)
                <section class="bg-white rounded-xl overflow-hidden text-dark shadow-xl swiper-slide recommendation-item-wrapper">
                    <img src="{{ asset('images/placeholder-02.png') }}" alt="" class="object-cover h-[210px] w-full" />

                    <section class="p-3 space-y-5 recommendation-item-details">
                        <div class="space-y-2">
                            <h2 class="text-md font-semibold">Cloak Dagger - Marvel</h2>
                            <div class="opacity-60 space-x-3 text-sm">
                                <span>2019</span>
                                <span>120 Episodes</span>
                            </div>
                        </div>
                    </section>
                </section>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('header')
<style>
   .recommendation-item-details {
        display: none; /* Hide details by default */
    }

    .swiper-slide-active .recommendation-item-details {
        display: block; /* Show details for active slide */
    }

    .swiper-slide-active.recommendation-item-wrapper {
        padding: 10px;
    }

    .swiper-slide-active.recommendation-item-wrapper img {
        border-radius: 10px;
    }
</style>
@endpush
@push('script')
<script>
    var swiper = new Swiper(".recommendation", {
          slidesPerView: 2,
          spaceBetween: 20,
        //   effect: "coverflow",
          grabCursor: true,
          centeredSlides: true,
        loop: true,
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