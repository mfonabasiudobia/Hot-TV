<div class="py-5 bg-black text-white space-y-5 w-full">
    <x-atoms.breadcrumb :routes="[['title' => 'Contact Us', 'route' => null ]]" />
    <div class="container  py-7">

        <section class="space-y-7">
            <header class="space-y-2">
                <h2 class="text-xl md:text-2xl font-semibold">Let’s get in touch.</h2>
                <p>When it comes to questions about billing, your Plex Pass subscription, and more, we’re all ears. Simply select your type
                of inquiry below and we’ll let the appropriate folks know.</p>
            </header>
            <form class="grid grid-cols-2 gap-5">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="First Name" wire:model.defer="first_name" />
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Last Name" wire:model.defer="last_name" />
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" placeholder="Email Address" wire:model.defer="email" />
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <input type="text" class="form-control" placeholder="Company" wire:model.defer="company" />
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" placeholder="Phone" wire:model.defer="phone" />
                </div>

                <div class="form-group">
                    <label>Mobile Phone Number</label>
                    <input type="text" class="form-control" placeholder="Mobile Phone Number"
                        wire:model.defer="mobile_number" />
                </div>

                <div class="form-group md:col-span-2">
                    <label>Message</label>
                    <textarea class="form-control" placeholder="Message" wire:model.defer="mobile_number" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-xl rounded-xl btn-danger">Submit</button>
                </div>

            </form>
        </section>

    </div>

    @livewire("home.partials.newsletter")
</div>