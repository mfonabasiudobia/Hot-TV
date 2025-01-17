<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl capitalize">Update Episode</h2>

        <section>
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group md:col-span-2">
                    <label>Customer</label>
                    <input type="text" placeholder="Title" wire:model='customer' disabled class="form-control" />
                    @error('title') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Driver</label>
                    <input type="text" placeholder="Slug" wire:model.defer='driver' disabled class="form-control" />
                    @error('slug') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Status</label>
                    <input type="text" placeholder="Slug" wire:model.defer='status' disabled class="form-control" />
                    @error('slug') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <x-atoms.toggle model="is_stream_blocked" label="Stream Blocked" />
                </div>

                <div class="form-group md:col-span-2 flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-danger" />
                </div>

            </form>
        </section>
    </section>
</section>
