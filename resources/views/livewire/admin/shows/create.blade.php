<section>
    @livewire("admin.gallery.modal.create")
    <section class="space-y-5">
        <h2 class="font-medium text-xl">Create TV Show</h2>

        <section>
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
                    
                    <div class="form-group">
                        <label>Show Categories</label>
                        <div class="relative" wire:ignore>
                            <select class="form-control" wire:model.defer="categories_id" multiple id="categories"
                                data-placeholder="--Categories--">
                                <option value="">--Select Categories--</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('categories_id') <span class="error"> {{ $message }}</span> @endError
                    </div>


                    <div class="form-group">
                        <label>Casts</label>
                        <div class="relative" wire:ignore>
                            <select class="form-control" wire:model.defer="casts_id" multiple id="casts"
                                data-placeholder="--Casts--">
                                <option value="">--Select Cast--</option>
                                @foreach ($casts as $cast)
                                <option value="{{ $cast->id }}">{{ $cast->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('casts_id') <span class="error"> {{ $message }}</span> @endError
                    </div>
                    
                    <div class="form-group">
                        <label>Release Date</label>
                        <div wire:ignore>
                            <input type="text" placeholder="Release Date" wire:model.defer='release_date'
                                class="form-control custom-datetime" />
                        </div>
                        @error('release_date') <span class="error">{{ $message }}</span> @endError
                    </div>
                    
                    <div class="form-group col-span-2" >
                        <label>Tags</label>

                        <div wire:ignore>
                            <select id="tags" class="form-control" multiple="multiple" data-placeholder="--Tags--"></select>
                        </div>
                        @error('tags') <span class="error"> {{ $message }}</span> @endError
                    </div>
                    
                    <div class="form-group" x-data="{ thumbnail : @entangle('thumbnail').defer }"
                        @set-push-file.window="if($event.detail.unique_key == 'thumbnail') thumbnail = $event.detail.path;">
                        <label>Thumbnail</label>
                        <input type="file" class="form-control" placeholder="Upload Image"
                            x-on:click.prevent="$wire.emit('openGallery', 'thumbnail')" />
                    
                        <img x-bind:src="'{{ file_path('/') }}/' + thumbnail" x-show="thumbnail ? true : false" class="image-preview"
                            x-cloak />
                    
                        @error('thumbnail') <span class="error"> {{ $message }}</span> @endError
                    </div>
                    
                    <div class="form-group" x-data="{ trailer : @entangle('trailer').defer }"
                        @set-push-file.window="if($event.detail.unique_key == 'trailer') trailer = $event.detail.path;">
                        <label>Upload Trailer</label>
                        <input type="file" class="form-control" x-on:click.prevent="$wire.emit('openGallery', 'trailer')" />
                    
                        <span x-text="'{{ file_path() }}' + trailer"></span>
                        <video class='w-auto h-[20vh]' controls>
                            <source :src="'{{ file_path() }}' + trailer" type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    
                        @error('trailer') <span class="error"> {{ $message }}</span> @endError
                    </div>
                </section>



                <div class="space-y-5 content-wrapper">
                    <div class="space-y-1">
                        <h1>SEO Information</h1>
                        <p class="font-light text-sm">Setup meta title & description to make your site easy to discovered on search
                            engines such as Google</p>
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" placeholder="Meta Title" wire:model.defer="meta_title" />
                        @error('meta_title') <span class="error"> {{ $message }}</span> @endError
                    </div>
                
                
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" placeholder="Meta Description" wire:model.defer="meta_description"></textarea>
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

@push('script')
<script>
    $(document).ready(function () {
    
                window.initSelectDrop = () => {
                    $("#categories").select2();

                    $("#casts").select2();

                    $("#tags").select2({
                        tags: "true",
                        selectOnClose: true,
                        tokenSeparators: [],
                    });
                }
                
                $('#categories').on('change', function (e) {
                    @this.set('categories_id', $(this).val());             
                });

                $('#casts').on('change', function (e) {
                    @this.set('casts_id', $(this).val());
                });
                
                $('#tags').on('change', function (e) {
                    @this.set('tags', $(this).val());
                });

                initSelectDrop();
                
                window.livewire.on('select2', () => {
                    initSelectDrop();
                })
    
});    
</script>
@endPush
