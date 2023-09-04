@php
    $tags = explode(',', $shortcode->suggested);
@endphp

<section class="section mt-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-40">
                @if ($subtitle = $shortcode->subtitle)
                    <span class="title-line line-48 wow animate__animated animate__fadeInUp" data-wow-delay=".0s">{{ $subtitle }}</span>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="color-brand-1 mt-15 mb-30 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">{{ $title }}</h2>
                @endif

                @if ($description = $shortcode->description)
                    <p class="font-md color-grey-500 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">{{ $description }}</p>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box-notify-me mt-15">
                            <form action="{{ route('public.search') }}">
                                <div class="inner-notify-me">
                                    <input class="form-control" name="q" type="text" required placeholder="{{ __('Search the doc...') }}">
                                    <button class="btn btn-brand-1 font-md">{{ __('Search') }}
                                        <svg class="w-6 h-6 icon-16 ms-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-45 wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                    <p class="font-sm-bold color-brand-1">{{ __('Suggested Search:') }}</p>
                </div>
                <div class="mt-10 wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                    @foreach($tags as $tag)
                        <a class="btn btn-tag-circle mr-10 mb-10" href="{{ route('public.search', ['q' => $tag]) }}">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7 mb-40 d-none d-md-block">
                <div class="box-banner-help">
                    @if ($image1 = $shortcode->image_1)
                        <div class="banner-img-1"><img src="{{ RvMedia::getImageUrl($image1) }}" alt="{{ __('Banner') }}"></div>
                    @endif

                    @if($image2 = $shortcode->image_2)
                        <div class="banner-img-2"><img src="{{ RvMedia::getImageUrl($image2) }}" alt="{{ __('Banner') }}"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
