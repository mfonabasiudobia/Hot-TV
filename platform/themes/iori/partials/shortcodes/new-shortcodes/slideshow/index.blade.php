@php
    $galleries = \Botble\Gallery\Models\Gallery::where('user_id', '!=', 1)
    ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED()->getValue())
    ->orderBy('created_at', 'desc')

    ->get()->take(5);

@endphp

<section class="py-10 bg-black">
    <div class="container space-y-3 overflow-hidden">
        <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="md:w-1/2 space-y-2">
                <h1 class="font-semibold text-xl md:text-2xl">{{ $shortcode->title }}</h1>
                <p class="text-sm">{{ $shortcode->description }}</p>
            </div>
            <a href="{{ route($shortcode->button_primary_url) }}" class="flex text-sm items-center space-x-1">
                <span>{{ $shortcode->button_primary_label }}</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>
        <div class="swiper recommendation">
            <div class="swiper-wrapper">
                @foreach ($galleries as $photo)
                    @php
                        $galleryMeta = \Botble\Gallery\Models\GalleryMeta::where('reference_id', $photo->id)->first();
                        if($galleryMeta) {
                            $image = $galleryMeta->images[0];
                            $img = explode('.', $image['img']);
                            $slideshowImage = $img[0] . '-150x150.'. $img[1];
                        } else {
                            continue;
                        }

                    @endphp
                    <a href="{{ route('gallery.detail', $photo->id) }}"
                       class="transition-all bg-black hover:bg-white p-2 rounded-xl overflow-hidden text-dark shadow-xl swiper-slide recommendation-item-wrapper group relative">
                        <img src="{{ asset( 'storage/' . $slideshowImage) }}" alt=""
                             class="object-cover h-[384px] w-full rounded-lg" />
                        <section class="p-3 space-y-5 recommendation-item-details invisible group-hover:visible">
                            <div class="space-y-2">
                                <h2 class="text-md font-semibold">{{ $photo->name }}</h2>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $photo->user->avatarUrl }}" alt=""
                                         class="w-[34px] h-[34px] rounded-full object-cover" />
                                    <span class="font-light">{{ $photo->user->name }}</span>
                                </div>
                            </div>
                        </section>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

