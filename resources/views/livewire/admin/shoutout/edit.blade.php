<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl">Edit Podcast</h2>

        <section x-data="{show_media: '{{ $media_type }}'}">
            <form class="space-y-5" wire:submit.prevent='submit'>
                <section class="space-y-3 content-wrapper">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" placeholder="Title" wire:model='title' class="form-control" />
                        @error('title') <span class="error">{{ $message }}</span> @endError
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" placeholder="Slug" wire:model.defer='slug' class="form-control" />
                        @error('slug') <span class="error">{{ $message }}</span> @endError
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <div wire:ignore>
                            <x-text-editor model="description" placeholder="Description" class="text-dark" />
                        </div>
                        @error('description') <span class="error">{{ $message }}</span> @endError
                    </div>

                    <div class="form-group" x-data="{ thumbnail : @entangle('thumbnail').defer }"
                        @set-push-file.window="if($event.detail.unique_key == 'thumbnail') thumbnail = $event.detail.path;">
                        <label>Thumbnail</label>
                        <input type="file" class="form-control" placeholder="Upload Image"
                            x-on:click.prevent="$wire.emit('openGallery', 'thumbnail')" />

                        <img x-bind:src="'{{ file_path('/') }}/' + thumbnail" x-show="thumbnail ? true : false"
                            class="image-preview" x-cloak />

                        @error('thumbnail') <span class="error"> {{ $message }}</span> @endError
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label>Media type</label>--}}
{{--                        <select class="form-control" placeholder="Media Type" wire:model.defer="media_type" readonly="readonly">--}}
{{--                            <option value="image">Image</option>--}}
{{--                            <option value="video">Video</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}

                    <div class="form-group" x-data="{ recorded_video : @entangle('recorded_video').defer }"
                        @set-push-file.window="if($event.detail.unique_key == 'recorded_video') recorded_video = $event.detail.path;"
                         x-show="show_media == 'video'"
                    >
                        <label>Upload Video</label>
                        <input type="file" class="form-control"
                            x-on:click.prevent="$wire.emit('openGallery', 'recorded_video')" />

                        <span x-text="'{{ file_path() }}' + recorded_video"></span>
                        <video class='w-auto h-[20vh]' :src="'{{ file_path() }}' + recorded_video" controls></video>

                        @error('recorded_video') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group" x-data="{ media_image : @entangle('media_image').defer }"
                         @set-push-file.window="if($event.detail.unique_key == 'media_image') media_image = $event.detail.path;"
                         x-show="show_media == 'image'"
                    >
                        <label  x-text="'Upload ' + show_media"></label>
                        <input type="file" class="form-control" placeholder="Upload Image"
                               x-on:click.prevent="$wire.emit('openGallery', 'media_image')" />

                        <img x-bind:src="'{{ file_path('/') }}/' + media_image" x-show="media_image ? true : false"
                             class="image-preview" x-cloak />

                        @error('media_image') <span class="error"> {{ $message }}</span> @endError
                    </div>
                    <div class="form-group">
                        <x-atoms.toggle model="status" label="Publish" />
                    </div>

                </section>


                <div class="space-y-5 content-wrapper">
                    <div class="space-y-1">
                        <h1>SEO Information</h1>
                        <p class="font-light text-sm">Setup meta title & description to make your site easy to
                            discovered on search
                            engines such as Google</p>
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" placeholder="Meta Title"
                            wire:model.defer="meta_title" />
                        @error('meta_title') <span class="error"> {{ $message }}</span> @endError
                    </div>


                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" placeholder="Meta Description"
                            wire:model.defer="meta_description"></textarea>
                        @error('meta_description') <span class="error"> {{ $message }}</span> @endError
                    </div>
                </div>

                <div class="form-group flex justify-end">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl btn-danger" />
                </div>

            </form>
        </section>
    </section>
</section>
