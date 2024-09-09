<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Gallery Detail', 'route' => null ]]" />
    <div class="container">
        <section>
            <section class="w-full max-h-screen relative">
                <section class="swiper slider">
                    <div class="swiper-wrapper">
                        @php
                            $galleryMeta = \Botble\Gallery\Models\GalleryMeta::where('reference_id', $photoGallery->id)->first();
                        @endphp
                        @if(isset($galleryMeta->images))
                            @foreach ($galleryMeta->images as $item)
                                <div class="swiper-slide">
                                    <img src="{{ asset( 'storage/' . $item['img']) }}" alt=""  :key="$loop->index" width="580" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-scrollbar"></div>
                </section>
            </section>

            <div class="space-y-7 mt-4">
                <div class="space-y-2">
                    <h2 class="text-md font-semibold">{{ $photoGallery->name }}</h2>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="{{ $photoGallery->user->avatarUrl }}" alt=""
                             class="w-[34px] h-[34px] rounded-full object-cover" />
                        <span class="font-light">{{ $photoGallery->user->name }}</span>
                    </div>
                </div>
                <div>
                    {{ $photoGallery->description }}
                </div>
            </div>
        </section>
    </div>
</div>

@push('script')

    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

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
