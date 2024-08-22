<section style="background-image: url('{{ file_path($shortcode->background) }}')">
    <section class="py-16">
        <div class="container grid md:grid-cols-2 gap-10">
            <section class="space-y-7 md:order-1 order-2">
                <div class="hidden md:flex items-center space-x-5">
                    <a class="text-danger" href="{{ route('live-channel.show') }}">
                        Live Channel
                    </a>

                    <a class="hover:text-danger" href="{{ route('pedicab-streams.home') }}">
                        Pedicab Streams
                    </a>

                    <a class="hover:text-danger" href="{{ route('tv-shows.home') }}">Tv Shows</a>
                </div>
                <h1 class="font-extrabold text-3xl md:text-5xl">{{ $shortcode->title }}</h1>
                <div class="space-y-5">
                    {!! $shortcode->description !!}
                </div>

                <div class="flex items-center space-x-5">
                    <a href="{!! $shortcode->button_primary_url !!}"
                        class="btn btn-danger btn-lg rounded-xl py-3 flex justify-between items-center space-x-5">
                        <span>{!! $shortcode->button_primary_label !!}</span>

                        <i class="las la-play"></i>
                    </a>

                    <button class="btn border btn-lg rounded-xl py-3 hover:bg-danger hover:border-danger">
                        {!! $shortcode->button_secondary_label !!}
                    </button>
                </div>
            </section>

            <section class="order-1 md:order-2 relative">
{{--                <img src="{{ file_path($shortcode->tv_channel_thumbnail) }}" alt="" />--}}

                <section class="w-full max-h-screen relative">
                    <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"></video>
                    <div class="custom-loader absolute left-[45%] top-[45%]" id="loading-button"></div>
                </section>

{{--                <a href="{{ route('live-channel.show') }}">--}}
{{--                    <img src="{{ asset('svg/btn-play-white.svg') }}" alt=""--}}
{{--                        class="absolute inset-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" />--}}
{{--                </a>--}}
            </section>
        </div>
    </section>

