<section class="py-10">
    <div class="container space-y-3 overflow-hidden">
        <h1 class="text-xl font-medium">Recently Watched</h1>
        <section class="swiper recently-watched">
            <div class="swiper-wrapper">
                @foreach ([1,2,3,4,5,6,7,8,9] as $item)
                <div class="bg-black p-5 rounded-3xl grid grid-cols-2 gap-5 swiper-slide">
                    <img src="{{ asset('images/placeholder.png') }}" alt="" class="h-[170px]" />
        
                    <div class="space-y-3">
                        <button class="btn border border-danger text-danger btn-lg rounded-xl py-2 px-3">
                            TV Show
                        </button>
        
                        <div class="space-y-5 flex flex-col justify-between">
                            <div>
                                <h2 class="text-lg font-medium">The Boxing Show</h2>
                                <p class="text-sm opacity-60">Episode 7</p>
                            </div>
        
                            <img src="{{ asset('images/progress.svg') }}" alt="" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex justify-center mt-7">
                <div class="flex items-center space-x-2">
                    <span class="recently-watched-swiper-button-prev las la-angle-left bg-white text-dark rounded-full text-xs px-0.5"></span>
                    <div class="swiper-paginations"></div>
                    <span class="recently-watched-swiper-button-next las la-angle-right bg-white text-dark rounded-full text-xs px-0.5"></span>
                </div>
            </div>
        </section>
    </div>
</section>

@push('header')
    <style>
        /* Override pagination bullet color */
        .swiper-pagination-bullet {
        background-color: white; /* Change to your desired color */
        opacity: 0.3; /* Optional: Adjust opacity if needed */
        }
        
        /* Override active pagination bullet color */
        .swiper-pagination-bullet-active {
        background-color: white; /* Change to your desired color */
        opacity: 1;
        }

        /* Change color for active swiper buttons */
        .recently-watched-swiper-button-next.swiper-button-disabled,
        .recently-watched-swiper-button-prev.swiper-button-disabled {
             opacity: 0.5;
        }
        
        /* Change color for disabled swiper buttons */
        .recently-watched-swiper-button-next.swiper-button-active,
        .recently-watched-swiper-button-prev.swiper-button-active {
            opacity: 1;
        }
    </style>
@endpush
@push('script')
    <script>
        var swiper = new Swiper(".recently-watched", {
          slidesPerView: 2,
          spaceBetween: 30,
          pagination: {
            el: ".swiper-paginations",
            clickable: true,
          },
          navigation: {
            nextEl: ".recently-watched-swiper-button-next",
            prevEl: ".recently-watched-swiper-button-prev",
        },
          breakpoints: {
            640: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            },
            1400: {
                slidesPerView: 4
            },
        }
        });
    </script>
@endpush