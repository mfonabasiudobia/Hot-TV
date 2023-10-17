<section style="background-image: url('{{ file_path($shortcode->background) }}" class="py-16">
    <div class="container space-y-10 overflow-hidden">
        <header class="md:w-3/4 text-center mx-auto space-y-3">
            <h1 class="font-semibold text-xl md:text-3xl">{{ $shortcode->title }}</h1>
            <p>{!! $shortcode->description !!}</p>
        </header>

        <div class="swiper most-viewed">
            <div class="swiper-wrapper">
                @foreach (\App\Repositories\StreamRepository::getMostStreamedVideos() as $item)
                <section class="bg-white rounded-xl overflow-hidden text-dark shadow-xl swiper-slide">
                    <img src="{{ file_path($item->thumbnail) }}" alt="" class="object-cover h-[210px] w-full" />

                    <section class="p-5 space-y-5">
                        <div class="flex items-center justify-between text-sm">
                            <div class="opacity-60 space-x-3">
                                <span>London Bridge</span>
                                <span>{{ convert_seconds_to_time(diff_start_end_time_seconds($item->start_time, $item->end_time)) }}</span>
                            </div>

                            <button class="text-danger btn bg-[#f2f3fa] btn-sm rounded-xl">Traveling</button>
                        </div>
                        <div class="space-y-2">
                            <h2 class="text-xl font-semibold">{{ $item->title }}</h2>
                            <p class="text-sm" style="min-height: 60px">
                                {{ sanitize_seo_description($item->description, 130) }}

                            </p>
                        </div>

                        <div class="flex items-center space-x-3 justify-between">
                            <div class="space-x-3 flex items-center">
                                <a href="{{ route('tv-channel.show', ['slug' => $item->id]) }}"
                                    class="btn border rounded-xl btn-lg py-3 text-danger hover:bg-danger hover:text-white">
                                    Watch Now
                                </a>

                                @if(is_user_logged_in())
                                    <button wire:click.prevent="saveToWatchlist({{ $item }})"
                                        class="btn border rounded-xl py-1 px-2 text-3xl text-danger hover:bg-danger hover:text-white {{ $item->watchlists()->where('user_id', auth()->id())->count() > 0 ? 'bg-danger text-white' : 'bg-white text-danger' }}">
                                        <i class="las la-heart"></i>
                                    </button>
                                @endIf
                            </div>


                            <div>
                                <span class="text-danger text-xl font-semibold">{{ view_count($item->views_count) }}</span>
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