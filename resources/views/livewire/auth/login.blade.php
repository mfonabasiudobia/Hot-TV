<main>
    @livewire("partials.header")
    <div 
        class="min-h-screen flex items-center justify-center" 
        style="background-image: url('{{ asset('images/background-image-01.png') }}">

        <div class="md:w-1/2 lg:w-1/3 border border-[#878787] rounded-xl bg-black text-white p-5">
            <header>
                <h1 class="font-medium text-lg md:text-4xl">Sign in to Hot TV Station</h1>
            </header>
            <form action="" class="grid gap-5">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Enter your user name" wire:model.defer="username" />
                </div>
                
                <div class="form-group" x-data="{ show : false}">
                    <label>Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" placeholder="Enter your Password" wire:model.defer="password" />
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <x-atoms.loading-button text="Log in" target="submit" class="btn btn-lg btn-danger btn-block" />
                </div>
            </form>
        </div>
    
    </div>
    @livewire("partials.footer")
</main>