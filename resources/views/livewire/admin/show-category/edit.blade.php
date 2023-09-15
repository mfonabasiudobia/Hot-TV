<section class="content-wrapper">
    <section class="flex justify-between items-center">
        <h1 class="title">Edit Show Category</h1>
    </section>


    <form wire:submit.prevent="submit" class="grid gap-5">

        <div class="form-group w-full">
            <label>Name</label>
            <input type="text" class="form-control text-dark" placeholder="Name*" wire:model.defer="name" />
            @error('name') <span class="error"> {{ $message }}</span> @endError
        </div>

        <div class="form-group w-full">
            <label>Order</label>
            <input type="text" class="form-control text-dark" placeholder="Order*" wire:model.defer="order" />
            @error('order') <span class="error"> {{ $message }}</span> @endError
        </div>


        <div class="form-group py-5 flex justify-end">
            <x-atoms.loading-button text="Submit" target="submit" class="btn btn-lg btn-primary btn-rounded" />
        </div>
    </form>

</section>