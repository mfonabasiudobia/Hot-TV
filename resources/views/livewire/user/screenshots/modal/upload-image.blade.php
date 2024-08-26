<div class="modal-wrapper text-white" x-data="{ status : false }" @trigger-upload-screenshot-modal.window="status = !status;"
    @trigger-close-modal.window="status = false" x-show="status" x-transition.duration.500ms x-cloak>
    <section class="modal-inner-wrapper p-7">
        <section class="modal-body rounded-lg shadow w-full sm:w-[500px] p-5 md:p-7 space-y-5 bg-dark"
            @click.outside="status = false">

            <header class="space-y-2">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl md:text-2xl font-semibold">Upload Image</h1>

                    <button class="text-xl" x-on:click.prevent="status = !status">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <p>Showcase your travel photos and experiences.</p>
            </header>

            <form wire:submit.prevent='submit' class="grid gap-5" autocomplete="off" >

                    <div class="form-group">
                        <label>Image Title *</label>
                        <input type="text" class="form-control" placeholder="Image Title" wire:model.defer="title" />
                        @error('title') <span class="error"> {{ $message }}</span> @endError
                    </div>


                    <div class="form-group">
                        <label>Image</label>
                        <span class="text-secondary block text-xs">Support *.png, *.jpeg, *.gif, *.jpg. Maximun upload file size: 5mb.</span>
                        <x-atoms.progress-indicator>
                            <input type="file" class="form-control" accept="image/*" wire:model.defer="images" multiple />
                        </x-atoms.progress-indicator>
                        @error('images.*') <span class="error"> {{ $message }}</span> @endError
                    </div>



                <div class="form-group">
                    <x-atoms.loading-button text="Upload Image" target="submit" class="btn btn-lg btn-danger" />
                </div>
            </form>

        </section>
    </section>
</div>
