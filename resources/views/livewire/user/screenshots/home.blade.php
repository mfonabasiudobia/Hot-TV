<div>
    @livewire("user.screenshots.modal.upload-image")
    <div class="py-16">
        <section class="container">
            @if(count($galleries) === 0)
                <p>There aren't any travel photos and experiences</p>
            @endIf

            <section class="grid grid-cols-2 md:grid-cols-4 gap-5 ">
                @foreach ($galleries as $photo)
                    <div class="rounded-xl border border-secondary hover:boder-danger overflow-hidden" :key="$loop->index">
                        <section class="swiper slider">
                            <div class="swiper-wrapper">
                                @php
                                    $galleryMeta = \Botble\Gallery\Models\GalleryMeta::where('reference_id', $photo->id)->first();
                                @endphp
                                @if(isset($galleryMeta->images))
                                    @foreach ($galleryMeta->images as $item)
                                        @php
                                            $img = explode('.', $item['img']);
                                            $slideshowImage = $img[0] . '-150x150.'. $img[1];
                                        @endphp
                                    <div class="swiper-slide">
                                        <img src="{{ asset( 'storage/' . $slideshowImage) }}" alt="" class="h-[160px] w-full object-cover" :key="$loop->index" />
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-scrollbar"></div>
                        </section>
                        <div class="p-3 text-sm md:flex-row flex items-start md:justify-between">
                            <span>
                                {{ $photo->name }}
                            </span>
                            <span class="text-xs text-center text-white {{ $photo->status == 'published' ?  'bg-success' : 'bg-danger'}} inline-block p-2">
                                {{ $photo->status }}
                            </span>

                        </div>
                    </div>
                @endforeach
            </section>
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
