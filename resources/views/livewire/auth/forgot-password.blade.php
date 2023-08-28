<div class="min-h-screen flex items-center justify-center py-10"
    style="background-image: url('{{ asset('images/background-image-01.png') }}">

    <div class="md:w-1/2 lg:w-[430px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
        <header class="space-y-3">
            <section class="space-y-2">
                <h1 class="font-medium text-2xl md:text-3xl">Forgot Password?</h1>
                <p>Provide the email address associated with your account. We'll send you a link to reset your password.</p>
            </section>
        </header>
        <form class="grid gap-5" wire:submit.prevent='submit'>

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Enter your email" wire:model.defer="email" />
                @error('email') <span class="error"> {{ $message }}</span> @endError
            </div>

            <div class="form-group">
                <x-atoms.loading-button text="Send" target="submit" class="btn btn-lg btn-danger btn-block" />
            </div>
        </form>

        <div class="text-center">
            <span class="font-thin">Oops? I remember my details </span> <a href="{{ route('login') }}"
                class="semibold">Login</a>
        </div>
    </div>
</div>