@php
    $galleries = \Botble\Gallery\Models\Gallery::where('user_id', '!=', 1)
    ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED()->getValue())
    ->orderBy('created_at')

    ->get()->take(4);
@endphp

<section class="py-10 bg-black">
    <div class="container space-y-3 overflow-hidden">
        <h1 class="text-xl font-medium">Slideshow</h1>
        <section class="container">
            <section class="grid grid-cols-2 md:grid-cols-4 gap-5 ">
                @foreach ($galleries as $photo)
                    <div class="rounded-xl border border-secondary hover:boder-danger overflow-hidden" :key="$loop->index">
                        <section class="swiper slideshow">
                            <div class="swiper-wrapper">
                                @php
                                    $galleryMeta = \Botble\Gallery\Models\GalleryMeta::where('reference_id', $photo->id)->first();
                                @endphp
                                @foreach ($galleryMeta->images as $item)
                                    @php
                                        $img = explode('.', $item['img']);
                                        $slideshowImage = $img[0] . '-150x150.'. $img[1];
                                    @endphp
                                    <div class="swiper-slide">
                                        <img src="{{ asset( 'storage/' . $slideshowImage) }}" alt="" class="h-[160px] w-full object-cover" :key="$loop->index" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-scrollbar"></div>
                        </section>
                        <div class="p-3 text-sm">
                            <h2>
                                {{ $photo->name }}
                            </h2>
                        </div>
                    </div>
                @endforeach
            </section>
        </section>
    </div>

@push('script')

    <script>
        const swiperslideshow = new Swiper('.slideshow', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });
    </script>
@endpush
