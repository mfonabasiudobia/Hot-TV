<section class="py-10">
    <div class="container space-y-3 overflow-hidden">
        <h1 class="text-xl font-medium">{{ $shortcode->title }}</h1>
        <section class="swiper recently-watched">
            <div class="swiper-wrapper">
                @foreach (\App\Repositories\TvShowRepository::recentlyWatched(user())->take(10) as $item)
                <a href="{{ route('tv-shows.show', ['slug' => $item->tvShow->slug, 'season' => $item->season_number, 'episode' => $item->slug ]) }}"
                    class="bg-black p-5 rounded-3xl grid grid-cols-2 gap-5 swiper-slide">
                    <img src="{{ file_path($item->thumbnail) }}" alt="" class="h-[164px] w-[142px] object-cover rounded-xl" />

                    <div class="space-y-3">
                        <button class="btn border border-danger text-danger btn-lg rounded-xl py-2 px-3">
                            {{-- {{ $item->tvcategories[0]->name }} --}}
                            Season  {{ $item->season_number }}
                        </button>

                        <div class="space-y-5 flex flex-col justify-between">
                            <div>
                                <h2 class="text-lg font-medium">{{ $item->tvShow->title }}</h2>
                                <p class="text-sm opacity-60">Episode {{ $item->episode_number }}</p>
                            </div>

                            <img src="{{ asset('images/progress.svg') }}" alt="" />
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="flex justify-center mt-7">
                <div class="flex items-center justify-center space-x-2">
                    <span
                        class="recently-watched-swiper-button-prev bg-white text-dark flex items-center justify-center rounded-full text-xs min-h-[24px] min-w-[24px]">
                        <i class="las la-angle-left"></i>
                    </span>
                    <div class="swiper-paginations"></div>
                    <span
                        class="recently-watched-swiper-button-next bg-white text-dark flex items-center justify-center rounded-full text-xs min-h-[24px] min-w-[24px]">
                        <i class="las la-angle-right"></i>
                    </span>
                </div>
            </div>
        </section>
    </div>
</section>
</section>

@push('header')
<style>
    /* Override pagination bullet color */
    .swiper-pagination-bullet {
        background-color: white !important;
        /* Change to your desired color */
        opacity: 0.3 !important;
        /* Optional: Adjust opacity if needed */
        width: 9px !important;
        height: 9px !important;
    }

    /* Override active pagination bullet color */
    .swiper-pagination-bullet-active {
        background-color: white !important;
        /* Change to your desired color */
        opacity: 1 !important;
        width: 9px !important;
        height: 9px !important;
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
          slidesPerView: 1,
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
                slidesPerView: 1
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