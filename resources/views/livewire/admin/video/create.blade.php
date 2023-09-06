<section>
    <section class="space-y-5">
        <h2 class="font-medium text-xl">Create Video</h2>

        {{ json_encode($errors->all()) }}
    
        <section>
    
            <form class="grid md:grid-cols-2 gap-5" wire:submit.prevent='submit'>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" placeholder="Title" wire:model.defer='title' class="form-control text-dark" />
                    @error('title') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group md:col-span-2">
                    <label>Video Description</label>
                    <textarea rows="5" placeholder="Video Description" wire:model.defer='description'
                        class="form-control text-dark"></textarea>
                    @error('description') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore>
                    <label>Schedule a Date</label>
                    <input type="text" placeholder="Date" wire:model='schedule_date'
                        class="form-control text-dark custom-date-from-today" />
                    @error('schedule_date') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore.self>
                    <label>Start time</label>
                    <input type="text" placeholder="Start Time" wire:model.defer='start_time'
                        class="form-control text-dark custom-time" />
                    @error('start_time') <span class="error">{{ $message }}</span> @endError
                </div>
    
                <div class="form-group" wire:ignore.self>
                    <label>End time</label>
                    <input type="text" placeholder="End Time" wire:model.defer='end_time'
                        class="form-control text-dark custom-time" />
                    @error('end_time') <span class="error">{{ $message }}</span> @endError
                </div>


                <div class="form-group" wire:ignore.self>
                    <label>Stream Type</label>
                    {{-- <input type="text" placeholder="End Time" wire:model.defer='end_time' class="form-control text-dark custom-time" /> --}}

                    <select class="form-control text-dark" wire:model.defer="stream_type">
                        <option value="uploaded_video">Uploaded Video</option>
                        <option value="podcast">Podcast</option>
                        <option value="pedicab_stream">Pedicab Stream</option>
                    </select>
                    @error('stream_type') <span class="error">{{ $message }}</span> @endError
                </div>

            

                <x-atoms.progress-indicator>
                    <label>Thumbnail</label>
                    <input type="file" wire:model.defer='thumbnail' accept="image/*" class="form-control text-dark" />
                    @error('thumbnail') <span class="error">{{ $message }}</span> @endError

                    @if($thumbnail)
                    <img src='{{ $thumbnail->temporaryUrl() }}' class='w-auto h-[20vh]' />
                    @endIF
                </x-atoms.progress-indicator>

    
                <x-atoms.progress-indicator>
                    <label>Upload Recorded Video</label>
                    <input type="file" wire:model.defer='recorded_video' accept="video/*" class="form-control text-dark" />
                    @error('recorded_video') <span class="error">{{ $message }}</span> @endError

                    @if($recorded_video)
                        <video class='w-auto h-[20vh]' controls>
                            <source src='{{ $recorded_video->temporaryUrl() }}' type='video/*'>
                            Your browser does not support HTML5 video.
                        </video>
                    @endIf
                </x-atoms.progress-indicator>
    
                <div class="form-group md:col-span-2 flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-primary" />
                </div>
    
            </form>
        </section>
    </section>
</section>

@push('script')
    <script>

    window.addEventListener("update-time-range", function (event) {

        flatpickr(".custom-time",{
                noCalendar : true,
                enableTime : true,
                dateFormat: "H:i",
                time_24hr: false,
                minTime: "00:00",
                maxTime: "23:59",
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
                        const startTime = instance.parseDate(range.from, "H:i");
                        const endTime = instance.parseDate(range.to, "H:i");
                        
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