@php
    $tabs = [];
    $quantity = min((int) $shortcode->quantity, 20);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            $tabs[] = [
                'title' => $shortcode->{'title_' . $i},
                'image' => $shortcode->{'image_' . $i},
                'data' => $shortcode->{'data_' . $i},
                'unit' => $shortcode->{'unit_' . $i},
            ];
        }
    }
@endphp

<section class="section pt-40 banner-about">
    <div class="container text-center">
        @if ($subtitle = $shortcode->subtitle)
            <h6 class="color-grey-400 mb-15">{{ $subtitle }}</h6>
        @endif

        @if ($title = $shortcode->title)
            <h2 class="color-brand-1 mb-15">{{ $title }}</h2>
        @endif

        @if ($description = $shortcode->description)
            <p class="font-md color-grey-400 mb-30">{{ $description }}</p>
        @endif

        <div class="box-radius-border mt-50">
            <div class="box-list-numbers">
                @foreach($tabs as $tab)
                    <div class="item-list-number">
                        <div class="box-image-bg">
                            <img src="{{ RvMedia::getImageUrl($tab['image']) }}" alt="{{ $tab['title'] }}">
                        </div>
                        <h2 class="color-brand-1">
                            <span class="count">{{ $tab['data'] }}</span>
                            <span>{{ $tab['unit'] }}</span>
                        </h2>
                        <p class="color-brand-1 font-lg">{{ $tab['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
