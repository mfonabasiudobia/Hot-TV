<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl capitalize">Create {{ $tvshow->title }} Episode</h2>

        <section>
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group md:col-span-2">
                    <label>Title</label>
                    <input type="text" placeholder="Title" wire:model='title' class="form-control-light" />
                    @error('title') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Slug</label>
                    <input type="text" placeholder="Slug" wire:model.defer='slug' class="form-control-light" />
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
                            class="form-control-light custom-datetime" />
                    </div>
                    @error('release_date') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Season Number</label>
                    <select wire:model.defer='season_number' class="form-control-light">
                        <option>--Select Season--</option>
                        @foreach (range(1, 50) as $item)
                        <option value="{{ $item }}">Season {{ $item }}</option>
                        @endforeach
                    </select>
                    @error('season_number') <span class="error">{{ $message }}</span> @endError
                </div>
                
                <div class="form-group">
                    <label>Episode Number</label>
                    <select wire:model.defer='episode_number' class="form-control-light">
                        <option>--Select Episode--</option>
                        @foreach (range(1, 50) as $item)
                        <option value="{{ $item }}">Episode {{ $item }}</option>
                        @endforeach
                    </select>
                    @error('episode_number') <span class="error">{{ $message }}</span> @endError
                </div>
                
                <div class="form-group">
                    <label>Duration</label>
                    <select wire:model.defer='duration' class="form-control-light">
                        <option>--Select Duration--</option>
                        @foreach (get_seconds_in_time_array() as $item)
                        <option value="{{ $item['seconds'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>
                
                    @error('duration') <span class="error">{{ $message }}</span> @endError
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
                    <input type="file" class="form-control"
                        x-on:click.prevent="$wire.emit('openGallery', 'recorded_video')" />

                    <span x-text="'{{ file_path() }}' + recorded_video"></span>
                    <video class='w-auto h-[20vh]' controls>
                        <source :src="'{{ file_path() }}' + recorded_video" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>

                    @error('recorded_video') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2 flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-primary" />
                </div>

            </form>
        </section>
    </section>
</section>