<div>
    @livewire("user.screenshots.modal.upload-image")
    <div class="py-16">
        <section class="container">
            @if(count($customPhotos) === 0)
                <p>There aren't any travel photos and experiences</p>
            @endIf

            <section class="grid grid-cols-2 md:grid-cols-4 gap-5 ">
                @foreach ($customPhotos as $photo)
                    <div class="rounded-xl border border-secondary hover:boder-danger overflow-hidden">
                        <section class="swiper slider">
                            <div class="swiper-wrapper">
                                @foreach ($photo->images as $item)
                                <img src="{{ asset($item) }}" alt="" class="h-[160px] w-full object-cover swiper-slide" />
                                @endforeach
                            </div>
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