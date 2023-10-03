<section class="py-16 bg-black">
    <div class="container">
        <div class="flex items-center justify-center flex-wrap space-x-7 md:space-x-16 mx-auto md:w-3/4">
            
            @foreach (\Botble\Brand\Models\Brand::all() as $brand)
                <div class="mb-7">
                    <img src="{{ file_path($brand->image) }}" title="{{ $brand->name }}" />
                </div>
            @endforeach

        </div>
    </div>
</section>