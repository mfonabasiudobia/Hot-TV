<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl capitalize">Add New Cast</h2>

        <section>
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group md:col-span-2">
                    <label>Name</label>
                    <input type="text" placeholder="Name" wire:model.defer='name' class="form-control" />
                    @error('name') <span class="error">{{ $message }}</span> @endError
                </div>

                {{-- <div class="form-group md:col-span-2">
                    <label>Character Role</label>
                    <input type="text" placeholder="Character Role" wire:model.defer='role' class="form-control" />
                    @error('role') <span class="error">{{ $message }}</span> @endError
                </div> --}}

                <div class="form-group md:col-span-2" x-data="{ image : @entangle('image').defer }"
                    @set-push-file.window="if($event.detail.unique_key == 'image') image = $event.detail.path;">
                    <label>Image</label>
                    <input type="file" class="form-control" placeholder="Upload Image"
                        x-on:click.prevent="$wire.emit('openGallery', 'image')" />

                    <img x-bind:src="'{{ file_path('/') }}/' + image" x-show="image ? true : false"
                        class="image-preview" x-cloak />

                    @error('image') <span class="error"> {{ $message }}</span> @endError
                </div>


                <div class="form-group md:col-span-2 flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-danger" />
                </div>

            </form>
        </section>
    </section>
</section>