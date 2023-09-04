@php
    $tabs = [];
    $quantity = min((int) $shortcode->quantity, 20);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            $tabs[] = [
                'title' => $shortcode->{'title_' . $i},
                'description' => $shortcode->{'description_' . $i},
                'icon_image' => $shortcode->{'icon_image_' . $i},
                'label' => $shortcode->{'label_' . $i},
                'url' => $shortcode->{'url_' . $i},
            ];
        }
    }
@endphp

<section class="section mt-50">
    <div class="container">
        <div class="row mt-50 align-items-center">
            <div class="col-lg-6 mb-30">
                @if ($subtitle = $shortcode->subtitle)
                    <div class="title-line mb-10 wow animate__animated animate__fadeInUp" data-wow-delay=".0s">{{ $subtitle }}</div>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="color-brand-1 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">{{ $title }}</h2>
                @endif
            </div>
            @foreach($tabs as $tab)
                <div class="col-lg-6 wow animate__animated animate__fadeIn">
                <div class="card-offer card-we-do hover-up">
                    @if ($tab['icon_image'])
                        <div class="card-image">
                            <img src="{{ RvMedia::getImageUrl($tab['icon_image']) }}" alt="{{ $tab['title'] }}" />
                        </div>
                    @endif
                    <div class="card-info">
                        @if ($tab['title'])
                            <h4 class="color-brand-1 mb-10">
                                <a class="color-brand-1" href="">{{ $tab['title'] }}</a>
                            </h4>
                        @endif

                        @if($tab['description'])
                            <p class="font-md color-grey-500 mb-5">{{ $tab['description'] }}</p>
                        @endif
                        <div class="box-button-offer">
                            @if($tab['label'] && $tab['url'])
                                <a class="btn btn-default font-sm-bold ps-0 color-brand-1">
                                    {{ $tab['label'] }}
                                    <svg class="w-6 h-6 icon-16 ms-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="box-button text-center mt-10 wow animate__animated animate__fadeIn">
            @if ($shortcode->button_primary_url && $shortcode->button_primary_label)
                <a class="btn btn-brand-1 hover-up" href="{{ $shortcode->button_primary_url }}">{{ $shortcode->button_primary_label }}</a>
            @endif

            @if($shortcode->button_secondary_url && $shortcode->button_secondary_label)
                <a class="btn btn-default font-sm-bold hover-up" href="{{ $shortcode->button_secondar_url }}">
                    {{ $shortcode->button_secondary_label }}
                    <svg class="w-6 h-6 icon-16 ms-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</section>
