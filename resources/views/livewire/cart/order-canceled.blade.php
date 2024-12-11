<div class="min-h-screen flex items-center justify-center py-10" style="background-image: url({{ asset('images/background-image-01.png') }}">
    <div  class="md:w-1/2 lg:w-[500px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
        <header class="space-y-3">
            <h3 class="font-thin text-xl">Order has been cancelled</h3>
            <section class="space-y-2">
                <h1 class="font-medium text-2xl md:text-3xl"></h1>
                <p>The order you placed has been cancelled</p>
            </section>


        </header>
        <div class="form-group">
            <a href="{{ route('merchandize.home') }}" type="button" class="btn btn-lg btn-danger btn-block" wire:click="next()">Continue shopping</a>
        </div>
    </div>
</div>
