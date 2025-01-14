<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl capitalize">Create Season</h2>

        <section>
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group md:col-span-2">
                    <label>Title</label>
                    <input type="text" placeholder="Title" wire:model='title' class="form-control" />
                    @error('title') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Slug</label>
                    <input type="text" placeholder="Slug" wire:model.defer='slug' class="form-control" />
                    @error('slug') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Description</label>
                    <div wire:ignore>
                        <x-text-editor model="description" placeholder="Description" class="text-dark" />
                    </div>
                    @error('description') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Release Date</label>
                    <div wire:ignore>
                        <input type="text" placeholder="Release Date" wire:model.defer='release_date'
                               class="form-control custom-datetime" />
                    </div>
                    @error('release_date') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Season Number</label>
                    <select wire:model.defer='season_number' class="form-control">
                        <option>--Select Season--</option>
                        @foreach (range(1, 50) as $item)
                            <option value="{{ $item }}">Season {{ $item }}</option>
                        @endforeach
                    </select>
                    @error('season_number') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Select TV Show</label>
                    <div wire:ignore>
                        <select wire:model.defer='tv_show_id' class="form-control tv-show">
                            <option>--Select TV Show--</option>
                            @foreach (\App\Models\TvShow::get() as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('tv_show_id') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group"></div>

                <div class="form-group">
                    <x-atoms.toggle model="status" label="Status" />
                </div>

                <div class="form-group md:col-span-2" x-data="{ thumbnail : @entangle('thumbnail').defer }"
                     @set-push-file.window="if($event.detail.unique_key == 'thumbnail') thumbnail = $event.detail.path;">
                    <label>Thumbnail</label>
                    <input type="file" class="form-control" placeholder="Upload Image"
                           x-on:click.prevent="$wire.emit('openGallery', 'thumbnail')" />

                    <img x-bind:src="'{{ file_path('/') }}/' + thumbnail" x-show="thumbnail ? true : false"
                         class="image-preview" x-cloak />

                    @error('thumbnail') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2" x-data="{ recorded_video : @entangle('recorded_video').defer }"
                     @set-push-file.window="if($event.detail.unique_key == 'recorded_video') recorded_video = $event.detail.path;">
                        <label>Upload Video</label>

                        <x-atoms.progress-indicator>
                            <input type="file" wire:model="recorded_video" class="form-control" accept="video/*" />
                        </x-atoms.progress-indicator>

                        @if($season->video)
                            @if($recorded_video)
                                <span>{{ $recorded_video->temporaryUrl() }}</span>
                                <video class='w-auto h-[20vh]' src="{{ $recorded_video->temporaryUrl() }}" controls></video>
                            @else
                                <span>{{ Storage::disk($season->video->disk ?? 'public')->url($season->video->path) }}</span>
                                <video class='w-auto h-[20vh]' src="{{ Storage::disk($season->video->disk ?? 'public')->url($season->video->path) }}" controls></video>
                            @endif

                        @else
                            @if($recorded_video)
                                <span>{{ $recorded_video->temporaryUrl() }}</span>
                                <video class='w-auto h-[20vh]' src="{{ $recorded_video->temporaryUrl() }}" controls></video>
                            @else
                                <span x-text="'{{ file_path() }}' + recorded_video"></span>
                                <video class='w-auto h-[20vh]' :src="'{{ file_path() }}' + recorded_video" controls></video>
                            @endif
                        @endif

                    @error('recorded_video') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2 flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-danger" />
                </div>

            </form>
        </section>
    </section>
</section>
@push('script')
    <script>
        $(document).ready(function () {
            $('.tv-show').select2();

            $('.tv-show').on('change', function (e) {
                @this.set('tv_show_id', e.target.value);
            });
        });
    </script>
@endpush
