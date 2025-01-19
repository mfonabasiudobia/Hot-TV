@php
    $liveStreams = \App\Models\Ride::where('stream_status', 'streaming')->orderBy('id', 'desc')->get()->take(12);
    $endedStreams = \App\Models\Ride::where('stream_status', 'completed')->orderBy('id', 'desc')->get()->take(12);
@endphp
<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex items-center justify-between">
            <div>
                <h1 class="font-semibold text-xl md:text-2xl">{{ $shortcode->title }}</h1>
                <p>{{ $shortcode->description }}</p>
            </div>
            <a href="{{ route('pedicab-streams.home', 1) }}" class="whitespace-nowrap flex text-sm items-center space-x-1">
                <span class="inline-block">View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>


        <div class="swiper live-streams">
            @if ($liveStreams->count() > 0)
                <div class="swiper-wrapper">
                    @foreach ($liveStreams as $item)
                        @if (!$item->is_stream_blocked)
                            <a href="{{ route('pedicab-streams.show', $item->id) }}"
                                style="background-size: cover; background-repeat: no-repeat; background-image: url('{{ $item->stream_thumbnail ?? 'https://placehold.co/600x400' }}')"
                                class="swiper-slide shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">

                                <button class="absolute top-1 p-2 bg-secondary b-r-2">
                                    <span class="text-danger">&bull;</span>
                                    Live
                                </button>

                                <button>
                                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                                </button>

                                <div
                                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                                    <div class="flex justify-between">
                                        <h2 class="font-bold">{{$item->customer->username}} - {{$item->street_name}}</h2>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item->customer->avatar_url }}" alt=""
                                                class="w-[34px] h-[34px] rounded-full object-cover" />
                                            <span class="font-light">{{$item->customer->username}}</span>
                                        </div>

                                        <span class="font-light">watching: {{$item->watching}}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-center mt-7">
                    <div class="flex items-center space-x-2">
                        <span
                            class="live-stream-swiper-button-prev border border-white hover:bg-white hover:text-dark rounded-full text-md flex items-center justify-center h-[30px] w-[30px]">
                            <i class="las la-arrow-left"></i>
                        </span>
                        <span
                            class="live-stream-swiper-button-next border border-white hover:bg-white hover:text-dark rounded-full text-md flex items-center justify-center h-[30px] w-[30px]">
                            <i class="las la-arrow-right"></i>
                        </span>
                    </div>
                </div>
            @else
                <p> No Live Stream Found </p>
            @endif
        </div>
    </div>
    <div class="container space-y-10 overflow-hidden mt-4">
        <header class="flex items-center justify-between">
            <div>
                <h1 class="font-semibold text-xl md:text-2xl">{{ $shortcode->title }}</h1>
                <p>{{ $shortcode->description }}</p>
            </div>
            <a href="{{ route('pedicab-streams.home', 1) }}" class="whitespace-nowrap flex text-sm items-center space-x-1">
                <span class="inline-block">View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>
        <div class="swiper ended-streams">
            @if ($endedStreams->count() > 0)
                <div class="swiper-wrapper">
                    @foreach ($endedStreams as $item)
                        @if (!$item->is_stream_blocked)
                            <a href="{{ route('pedicab-streams.show', $item->id) }}"
                                style="background-size: cover; background-repeat: no-repeat; background-image: url('{{ $item->stream_thumbnail ?? 'https://placehold.co/600x400' }}')"
                                class="swiper-slide shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">

                                <button class="absolute top-1 p-2">
                                    <i class="fas fa-eye-slash"></i>
                                </button>

                                <button>
                                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                                </button>

                                <div
                                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                                    <div class="flex justify-between">
                                        <h2 class="font-bold">{{$item->customer->username}} - {{$item->street_name}}</h2>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item->customer->avatar_url }}" alt=""
                                                class="w-[34px] h-[34px] rounded-full object-cover" />
                                            <span class="font-light">{{$item->customer->username}}</span>
                                        </div>

                                        <span class="font-light">views: {{$item->views}}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
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
            @else
                <p> No Data </p>
            @endif
        </div>
    </div>
</section>
@push('script')
<script>
    var swiper = new Swiper(".ended-streams", {
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
                slidesPerView: 4
            },
            1500: {
                slidesPerView: 4
            }
        }
        });

        // live streams
        var swiper = new Swiper(".live-streams", {
          slidesPerView: 1,
          spaceBetween: 30,
          pagination: {
            el: ".swiper-paginations",
            clickable: true,
          },
          navigation: {
            nextEl: ".live-stream-swiper-button-next",
            prevEl: ".live-stream-swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 4
            },
            1500: {
                slidesPerView: 4
            }
        }
        });
</script>
@endpush
