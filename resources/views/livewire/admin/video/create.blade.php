<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl">Create Stream</h2>

        <section>
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" placeholder="Title" wire:model.defer='title' class="form-control" />
                    @error('title') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group md:col-span-2">
                    <label>Video Description</label>
                   
                    <div wire:ignore>
                        <x-text-editor model="description" placeholder="Video Description" class="text-dark" id="description" />
                    </div>

                    @error('description') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore>
                    <label>Schedule a Date</label>
                    <input type="text" placeholder="Date" wire:model='schedule_date'
                        class="form-control custom-date-from-today" />
                    @error('schedule_date') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore.self>
                    <label>Start time</label>
                    <input type="text" placeholder="Start Time" wire:model.defer='start_time'
                        class="form-control custom-time" />
                    @error('start_time') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore.self>
                    <label>End time</label>
                    <input type="text" placeholder="End Time" wire:model.defer='end_time'
                        class="form-control custom-time" />
                    @error('end_time') <span class="error">{{ $message }}</span> @endError
                </div>


                <div class="form-group">
                    <label>Stream Type</label>
                    <select class="form-control" wire:model="stream_type">
                        <option value="uploaded_video">Uploaded Video</option>
                        <option value="podcast">Podcast</option>
                        <option value="pedicab_stream">Pedicab Stream</option>
                    </select>
                    @error('stream_type') <span class="error">{{ $message }}</span> @endError
                </div>

                @if(in_array($stream_type, ['uploaded_video']))
                    <div class="form-group">
                        <label>Uploaded Video Type</label>
                        <select class="form-control" wire:model="uploaded_video_type">
                            <option value="">--Uploaded Video Type--</option>
                            <option value="advertisement">Short Advertisement</option>
                            <option value="show_episode">Episode of a show</option>
                            <option value="pedicab_stream">Pedicab Stream</option>
                            <option value="general">General</option>
                        </select>
                        @error('uploaded_video_type') <span class="error">{{ $message }}</span> @endError
                    </div>
                @endIf

                @if(in_array($uploaded_video_type, ['show_episode']))
                    <div class="form-group">
                        <label>Show Category</label>
                        <select class="form-control" wire:model="show_category_id">
                            <option value="">--Select Show Category--</option>
                            @foreach (\App\Models\ShowCategory::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>     
                            @endforeach
                        </select>
                        @error('show_category_id') <span class="error">{{ $message }}</span> @endError
                    </div>

                    @if($show_category_id)
                        <div class="form-group">
                            <label>TV Shows</label>
                            <select class="form-control" wire:model="tv_show_id">
                                <option value="">--Select TV Show--</option>
                                @foreach ($tv_shows as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('tv_show_id') <span class="error">{{ $message }}</span> @endError
                        </div>
                    @endIf

                    @if($tv_show_id)
                        <div class="form-group">
                            <label>Season Number</label>
                            <select class="form-control" wire:model="season_number">
                                <option value="">--Select Season Number--</option>
                                @foreach ($tv_show_seasons as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            @error('season_number') <span class="error">{{ $message }}</span> @endError
                        </div>
                    @endIf

                    @if($season_number)
                        <div class="form-group">
                            <label>TV Show Episodes</label>
                            <select class="form-control" wire:model="episode_id">
                                <option value="">--Select Season Number--</option>
                                @foreach ($tv_show_episodes as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('episode_id') <span class="error">{{ $message }}</span> @endError
                        </div>
                    @endIf

                @endIf

                

                <div class="form-group md:col-span-2" x-data="{ thumbnail : @entangle('thumbnail').defer }"
                    @set-push-file.window="if($event.detail.unique_key == 'thumbnail') thumbnail = $event.detail.path;">
                    <label>Thumbnail</label>
                    <input type="file" class="form-control" placeholder="Upload Image"
                        x-on:click.prevent="$wire.emit('openGallery', 'thumbnail')" />
                
                    <img x-bind:src="'{{ file_path('/') }}/' + thumbnail" x-show="thumbnail ? true : false" class="image-preview"
                        x-cloak />
                
                    @error('thumbnail') <span class="error"> {{ $message }}</span> @endError
                </div>
                
                <div class="form-group md:col-span-2" x-data="{ recorded_video : @entangle('recorded_video').defer }"
                    @set-push-file.window="if($event.detail.unique_key == 'recorded_video') recorded_video = $event.detail.path;">
                    <label>Upload Video</label>
                    <input type="file" class="form-control" x-on:click.prevent="$wire.emit('openGallery', 'recorded_video')" />
                
                    <div class="flex justify-center flex-col items-center space-y-3">
                        <span x-text="'{{ file_path() }}' + recorded_video"></span>
                        <video class='w-1/2' x-bind:src="'{{ file_path() }}' + recorded_video" controls></video>
                    </div>
                
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

    window.addEventListener('added-tv-episode', function(event){
        // Get the TinyMCE editor instance
        var editor = tinymce.get('description');
        
        if (editor) {
            editor.setContent(event.detail);
        }
    })

    window.addEventListener("update-time-range", function (event) {

        flatpickr(".custom-time",{
                noCalendar : true,
                enableTime : true,
                dateFormat: "H:i:S",
                time_24hr: false,
                minTime: "00:00:00",
                enableSeconds: true,
                maxTime: "23:59:59",
                minuteIncrement: 1,
                altFormat : "h:i K",
                disable: event.detail.time_range,
                onChange: function(selectedDates, dateStr, instance) {
                        const selectedTime = selectedDates[0];

                        console.log(instance.config.disable);
                        
                        // Reset the input and remove the background color
                        instance.input.classList.remove("bg-danger");
                        
                        // Check if the selected time falls within the restricted ranges
                        instance.config.disable.forEach(function(range) {
                        const startTime = instance.parseDate(range.from, "H:i:S");
                        const endTime = instance.parseDate(range.to, "H:i:S");
                        
                        if (selectedTime >= startTime && selectedTime <= endTime) { 
                            instance.input.value="Not available" ;
                            instance.input.classList.add("bg-danger"); 
                        } 
                }); 
            } 
        });

    });
    </script>
@endpush