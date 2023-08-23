<section 
style="background-image: url('{{ asset('images/background-image-02.png') }}"
class="py-16">
    <div class="container space-y-10 overflow-hidden">
        <header class="md:w-3/4 text-center mx-auto space-y-3">
            <h1 class="font-semibold text-xl md:text-3xl">Most Viewed / Past Streams & Videos</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
            aliqua.</p>
        </header>

        <div class="swiper most-viewed">
            <div class="swiper-wrapper">
            @foreach ([1,2,3,4,5,6,7,8] as $item)
                <section class="bg-white rounded-xl overflow-hidden text-dark shadow-xl swiper-slide">
                    <img src="{{ asset('images/stream-01.png') }}" alt="" class="object-cover h-[210px] w-full" />
                
                    <section class="p-5 space-y-5">
                        <div class="flex items-center justify-between text-sm">
                            <div class="opacity-60 space-x-3">
                                <span>London Bridge</span>
                                <span>1hr 2min</span>
                            </div>
                
                            <button class="text-danger btn bg-[#f2f3fa] btn-sm rounded-xl">Traveling</button>
                        </div>
                        <div class="space-y-2">
                            <h2 class="text-xl font-semibold">Love of Street Food</h2>
                            <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore
                                magna
                                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
                        </div>
                
                        <div class="flex items-center space-x-3 justify-between">
                            <div class="space-x-3 flex items-center">
                                <a href="{{ route('tv-shows.show', ['slug' => 'love-of-the-street']) }}" class="btn border rounded-xl btn-lg py-3 text-danger hover:bg-danger hover:text-white">
                                    Watch Now
                                </a>
                
                                <button class="btn border rounded-xl py-1 px-2 text-3xl text-danger hover:bg-danger hover:text-white">
                                    <i class="las la-heart"></i>
                                </button>
                            </div>
                
                
                            <div>
                                <span class="text-danger text-xl font-semibold">21.9k</span>
                                <span class="opacity-60 text-sm">Views</span>
                            </div>
                        </div>
                    </section>
                </section>
            @endforeach
            </div>

            <div class="flex justify-center mt-7">
                <div class="flex items-center space-x-2">
                    <span
                        class="most-viewed-swiper-button-prev border border-white hover:bg-white hover:text-dark rounded-full text-md flex items-center justify-center h-[30px] w-[30px]">
                        <i class="las la-arrow-left"></i>
                    </span>
                    <span
                        class="most-viewed-swiper-button-next border border-white hover:bg-white hover:text-dark rounded-full text-md flex items-center justify-center h-[30px] w-[30px]">
                        <i class="las la-arrow-right"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

@push('header')
<style>
    /* Change color for active swiper buttons */
    /* .most-viewed-swiper-button-next.swiper-button-disabled,
    .most-viewed-swiper-button-prev.swiper-button-disabled {
        background-color: transparent;
        color: #fff !important;
    } */

    /* Change color for disabled swiper buttons */
    /* .most-viewed-swiper-button-next.swiper-button-active,
    .most-viewed-swiper-button-prev.swiper-button-active {
        background-color: #fff !important;
    } */
</style>
@endpush
@push('script')
<script>
    var swiper = new Swiper(".most-viewed", {
          slidesPerView: 1,
          spaceBetween: 30,
          pagination: {
            el: ".swiper-paginations",
            clickable: true,
          },
          navigation: {
            nextEl: ".most-viewed-swiper-button-next",
            prevEl: ".most-viewed-swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            },
            1500: {
                slidesPerView: 4
            }
        }
        });
</script>
@endpush