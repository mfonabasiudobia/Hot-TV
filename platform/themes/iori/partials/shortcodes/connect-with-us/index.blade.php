@php
    $tabs = [];
        $quantity = min((int) $shortcode->quantity, 20);
        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                $tabs[] = [
                    'title' => $shortcode->{'title_' . $i},
                    'image' => $shortcode->{'image_' . $i},
                    'description' => $shortcode->{'description_' . $i},
                ];
            }
        }
@endphp

<section class="section mt-110">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-6 mb-20">
                @if ($title = $shortcode->title)
                    <h2 class="color-brand-1 mb-0 wow animate__animated animate__fadeIn" data-wow-delay=".s">{{ $title }}</h2>
                @endif
            </div>
            <div class="col-lg-6 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                @if ($description = $shortcode->description)
                    <p class="color-grey-500 font-md mb-20">{{ $description }}</p>
                @endif

                @if($shortcode->button_url  && $shortcode->button_label)
                    <a class="btn btn-default p-0 font-sm-bold hover-up" href="{{ $shortcode->button_url }}">{{ $shortcode->button_label }}
                        <svg class="w-6 h-6 icon-16 ms-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
        <div class="row mt-45">
            @foreach($tabs as $tab)
                @if($loop->odd)
                    <div class="col-lg-4 wow animate__animated animate__fadeIn" data-wow-delay=".{{ $loop->index }}s">
                        <div class="card-human">
                            @if($tab['image'])
                                <div class="card-image mb-15">
                                    <img src="{{ RvMedia::getImageUrl($tab['image']) }}" alt="{{ $tab['title'] }}">
                                </div>
                            @endif

                            <div class="card-info mb-30">
                                @if ($tab['title'])
                                    <h4 class="color-brand-1 mt-15 mb-10">{{ $tab['title'] }}</h4>
                                @endif

                                @if ($tab['description'])
                                    <p class="font-sm color-grey-500">{!! BaseHelper::clean($tab['description']) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-4 wow animate__animated animate__fadeIn" data-wow-delay=".{{ $loop->index }}s">
                        <div class="card-human">
                            <div class="card-info mb-30">
                            @if ($title = $shortcode->title)
                                <h4 class="color-brand-1 mt-15 mb-10">{{ $title }}</h4>
                            @endif

                            @if ($description = $shortcode->description)
                                <p class="font-sm color-grey-500">{{ $description }}</p>
                            @endif
                            </div>
                            @if ($tab['image'])
                                <div class="card-image mb-15">
                                    <img src="{{ RvMedia::getImageUrl($tab['image']) }}" alt="{{ $tab['title'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
