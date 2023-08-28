<div class="min-h-screen flex items-center justify-center py-10"
        style="background-image: url('{{ asset('images/background-image-01.png') }}">

        <div class="md:w-1/2 lg:w-[430px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
            <header class="space-y-3">
                <h3 class="font-thin text-xl">Welcome !</h3>
                <section class="space-y-2">
                    <h1 class="font-medium text-2xl md:text-3xl">Sign up to Hot TV Station</h1>
                    <p>Your Next Stop for Traveling and streaming Station</p>
                </section>
            </header>
            <form class="grid gap-5" wire:submit.prevent='submit'>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter your email" wire:model.defer="email" />
                    @error('email') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Enter your username" wire:model.defer="username" />
                    @error('username') <span class="error"> {{ $message }}</span> @endError
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
                    @error('password') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group" x-data="{ show : false}">
                    <label>Confirm Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" placeholder="Confirm your Password"
                            wire:model.defer="password_confirmation" />
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group flex items-start space-x-2">
                    <input type="checkbox" id="agree" class="accent-danger mt-1 w-[20px] h-[20px]" required />
                    <label for="agree">I agree to Hot TV Station's terms and conditions, Learn more</label>
                </div>

                <div class="form-group">
                    <x-atoms.loading-button text="Register" target="submit" class="btn btn-lg btn-danger btn-block" />
                </div>
            </form>

            <div class="text-center">
                <span class="font-thin">Already have an Account ? </span> <a href="{{ route('login') }}" class="semibold">Login</a>
            </div>
        </div>
</div>