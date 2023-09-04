<section style="background-image: url('{{ asset('images/newsletter-background.png') }}" class="py-16">
    <div class="container">
        <div class="md:w-2/5 mx-auto space-y-7">
            <h1 class="font-semibold text-xl md:text-3xl text-center">
                Subscribe our newsletter for newest Tv shows updates
            </h1>

            <form class="flex items-center space-x-3" wire:submit.prevent='submit'>
                <div class="form-group w-full">
                    <input 
                        type="email" 
                        placeholder="Type your email here" 
                        wire:model.defer='email'
                        class="form-control border-0 rounded-xl py-4 px-5 bg-[#F3F3F3] bg-opacity-20" 
                    />
                </div>
                <div class="form-group">
                    <x-atoms.loading-button text="SUBSCRIBE" target="submit" class="text-danger bg-white py-4 px-5 rounded-xl font-semibold text-sm" />
                </div>
            </form>
            @error('email')
            <span class="error text-light">{{ $message }}</span>
            @endError
        </div>
    </div>
</section>