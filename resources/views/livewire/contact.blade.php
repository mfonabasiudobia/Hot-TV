<div class="py-5 bg-black text-white space-y-5 w-full">
    <x-atoms.breadcrumb :routes="[['title' => 'Contact Us', 'route' => null ]]" />
    <div class="container  py-7">

        <section class="space-y-7">
            <header class="space-y-2">
                <h2 class="text-xl md:text-2xl font-semibold">Let's get in touch.</h2>
                <p>When it comes to questions about billing, your Hot TV subscription, and more, we're all ears. Simply select your type
                of inquiry below and we'll let the appropriate folks know.</p>
            </header>
            <form class="grid grid-cols-2 gap-5" wire:submit.prevent="submit">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="First Name" wire:model.defer="first_name" />
                    @error('first_name') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Last Name" wire:model.defer="last_name" />
                    @error('last_name') <span class="error"> {{ $message }}</span> @endError
                </div>
      
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" placeholder="Email Address" wire:model.defer="email" />
                    @error('email') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Mobile Phone Number</label>
                    <input type="text" class="form-control" placeholder="Mobile Phone Number" wire:model.defer="mobile_number" />
                    @error('mobile_number') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Subject</label>
                    <input type="text" class="form-control" placeholder="Subject" wire:model.defer="subject" />
                    @error('subject') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Message</label>
                    <textarea class="form-control" placeholder="Message" wire:model.defer="message" rows="5"></textarea>
                    @error('message') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <x-atoms.loading-button text="Submit" target="submit" class="btn btn-xl rounded-xl btn-danger" />
                </div>

            </form>
        </section>

    </div>

    @livewire("home.partials.newsletter")
</div>