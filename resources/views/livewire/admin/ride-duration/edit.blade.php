<section class="content-wrapper">
    <section class="flex justify-between items-center">
        <h1 class="title">Edit Duration</h1>
    </section>

    <form wire:submit.prevent="submit" class="grid gap-5">

        <div class="form-group w-full">
            <label>Duration</label>
            <label>
                <select class="form-control" wire:model.defer="duration">
                    <option data-placeholder="true">--Select Ride Duration--</option>
                    <option value="5-minutes">5 Minutes</option>
                    <option value="10-minutes">10 Minutes</option>
                    <option value="15-minutes">15 Minutes</option>
                    <option value="30-minutes">30 Minutes</option>
                    <option value="1-hour">1 Hour</option>
                    <option value="2-hours">2 Hours</option>
                    <option value="3-hours">3 Hours</option>
                    <options value="5-hours">5 Hours</options>
                </select>
            </label>
            {{--            <input type="text" class="form-control" placeholder="Duration*" wire:model.defer="duration" />--}}
            @error('duration') <span class="error"> {{ $message }}</span> @endError
        </div>

        <div class="form-group w-full">
            <label>Price</label>
            <input type="text" class="form-control" placeholder="Price*" wire:model.defer="price" />
            @error('price') <span class="error"> {{ $message }}</span> @endError
        </div>
        <div class="form-group">
            <x-atoms.toggle model="stream" label="Stream" />
        </div>
{{--        <div class="form-group w-full">--}}
{{--            <label>Stream</label>--}}
{{--            <input type="text" class="form-control" placeholder="Stream*" wire:model.defer="stream" />--}}
{{--            @error('stream') <span class="error"> {{ $message }}</span> @endError--}}
{{--        </div>--}}


        <div class="form-group py-5 flex justify-end">
            <x-atoms.loading-button text="Submit" target="submit" class="btn btn-lg btn-primary btn-rounded" />
        </div>
    </form>

</section>
