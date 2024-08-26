<div>
    @livewire("user.screenshots.modal.upload-image")
    <div class="py-16">
        <section class="container">
            @if(count($customPhotos) === 0)
                <p>There aren't any travel photos and experiences</p>
            @endIf

            <section class="grid grid-cols-2 md:grid-cols-4 gap-5 ">
                @foreach ($customPhotos as $photo)
                    <div class="rounded-xl border border-secondary hover:boder-danger overflow-hidden" :key="$loop->index">
                        <section class="swiper slider">
                            <div class="swiper-wrapper">
                                @foreach ($photo->images as $item)
                                <div class="swiper-slide">
                                    <img src="{{ asset($item) }}" alt="" class="h-[160px] w-full object-cover" :key="$loop->index" />
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-scrollbar"></div>
                        </section>
                        <div class="p-3 text-sm">
                            <h2>
                                {{ $photo->title }}
                            </h2>
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
