<div>
    @livewire("user.screenshots.modal.upload-image")
    <div class="py-16">
        <section class="container">
            @if(count($customPhotos) === 0)
                <p>There aren't any travel photos and experiences</p>
            @endIf

            <section class="grid grid-cols-4 gap-5">
                @foreach ($customPhotos as $photo)
                    <div class="rounded-xl overflow-hidden border border-secondary hover:boder-danger">
                        <img src="{{ asset($photo->image) }}" alt="" class="h-[160px] w-full object-cover" />
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