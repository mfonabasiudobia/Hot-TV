<div class="modal-wrapper" x-data="{ status : false }" @trigger-file-modal.window="status = !status;"
    @trigger-close-modal.window="status = false" x-show="status" x-transition x-cloak>
    <section class="modal-inner-wrapper p-7">
        <section class="modal-body rounded-lg shadow md:w-1/2 p-5 md:p-7 space-y-5 bg-dark" @click.outside="status = false">

            <header>
                <h1 class="text-xl md:text-2xl font-bold">User Profile</h1>
            </header>

            <form wire:submit.prevent='submit' class="grid gap-5">
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First name" wire:model.defer="first_name" />
                        @error('first_name') <span class="error"> {{ $message }}</span> @endError
                    </div>
                
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last name" wire:model.defer="last_name" />
                        @error('last_name') <span class="error"> {{ $message }}</span> @endError
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter your email" wire:model.defer="email" />
                    @error('email') <span class="error"> {{ $message }}</span> @endError
                </div>
                
                <div class="form-group" x-data="{ show : false}">
                    <label>Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" placeholder="Enter your Password"
                            wire:model.defer="password" />
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group" x-data="{ show : false}">
                    <label>Confirm Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" placeholder="Confirm Password"
                            wire:model.defer="password_confirmation" />
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <x-atoms.loading-button text="Save Update" target="submit" class="btn btn-xl btn-danger" />
                </div>
            </form>

        </section>
    </section>
</div>