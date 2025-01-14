<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl capitalize">Update Episode</h2>

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
                    <label>Select TV Show</label>
                    <div wire:ignore>
                        <select wire:model.defer='tv_show_id' class="form-control tv-show" wire:change="UpdateSeasons">
                            <option>--Select TV Show--</option>
                            @foreach (\App\Models\TvShow::get() as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('tv_show_id') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Season Number</label>
                    <select wire:model.defer='season_id' class="form-control" wire:change="UpdateStartRange">
                        <option>--Select Season--</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}">Season {{ $season->season_number }}</option>
                        @endforeach
                    </select>
                    @error('season_number') <span class="error">{{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Episode Number</label>
                    <select wire:model.defer='episode_number' class="form-control" >
                        <option>--Select Episode--</option>
                        @foreach (range(1, 50) as $item)
                            @if(! in_array($item, $selectedEpisodes) || $episode_number == $item)
                                <option value="{{ $item }}">Episode {{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('episode_number') <span class="error">{{ $message }}</span> @endError
                </div>

                <!-- <div class="form-group">
                    <label>Duration</label>
                    <select wire:model.defer='duration' class="form-control">
                        <option>--Select Duration--</option>
                        @foreach (get_seconds_in_time_array() as $item)
                        <option value="{{ $item['seconds'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>

                    @error('duration') <span class="error">{{ $message }}</span> @endError
                </div> -->

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

                        @if($episode->video)
                            @if($recorded_video)
                                <span>{{ $recorded_video->temporaryUrl() }}</span>
                                <video class='w-auto h-[20vh]' src="{{ $recorded_video->temporaryUrl() }}" controls></video>
                            @else
                                <span>{{ Storage::disk($episode->video->disk ?? 'public')->url($episode->video->path) }}</span>
                                <video class='w-auto h-[20vh]' src="{{ Storage::disk($episode->video->disk ?? 'public')->url($episode->video->path) }}" controls></video>
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
        document.addEventListener('DOMContentLoaded', function () {
            const releaseDateInput = document.querySelector('.custom-datetime');

            if (releaseDateInput) {
                flatpickr(releaseDateInput, {
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i',
                    defaultDate: "{{ $release_date }}",
                });
            }
        })
        $(document).ready(function () {
            $('.tv-show').select2();

            $('.tv-show').on('change', function (e) {
                    @this.set('tv_show_id', e.target.value);
                });
            });
    </script>
@endpush
