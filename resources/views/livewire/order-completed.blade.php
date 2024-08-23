<div class="min-h-screen flex items-center justify-center py-10" style="background-image: url({{ asset('images/background-image-01.png') }}">
    <div  class="md:w-1/2 lg:w-[500px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
        <header class="space-y-3">
            <h3 class="font-thin text-xl">Order placed successfully</h3>
            <section class="space-y-2">
                <h1 class="font-medium text-2xl md:text-3xl"></h1>
                <p>You have successfully placed your order. Below is the order details.</p>
            </section>

            <section class="space-y-5 md:p-5">
                <h2 class="text-xl font-semibold">Shopping Summary</h2>

                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <span>Sub Total</span>
                        <span class="font-semibold text-xl">{{ ac() . number_format($subTotal, 2)  }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Discount Amount</span>
                        <span class="font-semibold text-xl">-{{ ac() . number_format($discountAmount, 2) }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Tax Amount</span>
                        <span class="font-semibold text-xl">{{ ac() . number_format($taxAmount, 2) }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <span>Total Amount</span>
                        <span class="font-semibold text-xl">{{ ac() . number_format($subTotal, 2) }}</span>
                    </li>
                </ul>

            </section>
        </header>
        <div class="form-group">
            <a href="{{ route('merchandize.home') }}" type="button" class="btn btn-lg btn-danger btn-block" wire:click="next()">Continue shopping</a>
        </div>
    </div>
</div>
