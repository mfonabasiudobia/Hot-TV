<div class="modal-wrapper text-white" x-data="{ status : false }" @trigger-upload-video-modal.window="status = !status;"
    @trigger-close-modal.window="status = false" x-show="status" x-transition.duration.500ms x-cloak>
    <section class="modal-inner-wrapper p-7">
        <section class="modal-body rounded-lg shadow w-full sm:w-[500px] p-5 md:p-7 space-y-5 bg-dark"
            @click.outside="status = false">

            <header class="space-y-2">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl md:text-2xl font-semibold">Submit Video</h1>
                
                    <button class="text-xl" x-on:click.prevent="status = !status">
                        <i class="las la-times"></i>
                    </button>
                </div>
                
                <p>Please fill in all information bellow to submit video.</p>
            </header>

            <form wire:submit.prevent='submit' class="grid gap-5" autocomplete="off" x-data="{ video_type : @entangle('video_type')}">

                    <div class="form-group">
                        <label>Video Title *</label>
                        <input type="text" class="form-control" placeholder="Video Title" wire:model.defer="title" />
                        @error('title') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group" wire:ignore>
                        <label>Video Description</label>
                        <x-text-editor model="description" placeholder="Video Description" rows="3" />
                        @error('description') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group flex flex-col justify-start items-start">
                        <label>Choose Video Submit Method</label>
                        <select  class="form-control-inline bg-dark" x-model="video_type">
                            <option value="file" selected="selected">Upload Video</option>
                            <option value="url">Video URL or Embed</option>
                        </select>
                    </div>

                    <div class="form-group" x-show="video_type === 'file'">
                        <label>Video File</label>
                        <span class="text-secondary block text-xs">Support *.mp4, *.m4v, *.webm, *.ogv, *.flv, *.mov. Maximun upload file size: 5mb.</span>                       

                        <x-atoms.progress-indicator>
                            <input type="file" wire:model="video_file" class="form-control" accept="video/*" />
                        </x-atoms.progress-indicator>

                        @error('video_file') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group" wire:ignore x-show="video_type === 'url'">
                        <label>Video URL or Embed</label>
                        <x-text-editor model="video_url" placeholder="Video URL or Embed" rows="3" />
                        @error('video_url') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group">
                        <label>Video Thumbnail</label>
                        <span class="text-secondary block text-xs">Support *.png, *.jpeg, *.gif, *.jpg. Maximun upload file size: 5mb.</span>
                        <x-atoms.progress-indicator>
                            <input type="file" class="form-control" accept="image/*" wire:model.defer="thumbnail" />
                        </x-atoms.progress-indicator>
                        @error('thumbnail') <span class="error"> {{ $message }}</span> @endError
                    </div>



                <div class="form-group">
                    <x-atoms.loading-button text="Submit Video" target="submit" class="btn btn-lg btn-danger" />
                </div>
            </form>

        </section>
    </section>
</div>