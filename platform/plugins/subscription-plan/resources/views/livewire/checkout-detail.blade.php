<div class="py-5 bg-black text-white space-y-5 min-h-screen" style="background-image: url('{{ asset('images/background-image-01.png') }}">

    <form name="form1" class="container items-center justify-center grid py-7" method="POST" action="{{ route('plan.checkout') }}">
        @csrf


        <section class="md:w-1/2 lg:w-[500px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
            <div class="bg-dark rounded-2xl p-5 space-y-5">
                <h2 class="text-xl md:text-2xl font-semibold">Order Details</h2>

               <div class="overflow-auto">
                <table class="w-full">
                    <tr>
                        <td>
                            <section class="flex items-center space-x-3 w-[320px]">
                                <!-- <img src="file_path($cart->model->images[0])" alt="" class="h-[100px] w-auto rounded-xl" /> -->

                                <div class="space-y-2">
                                    <h2 class="font-semibold text-xl">{{ $subscription->name }}</h2>
                                </div>
                            </section>
                        </td>
                        <td class="font-medium text-xl">
                            <span>{{ ac() . number_format($subscription->price, 2) }}</span>

                            <!-- if($cart->model->sale_price > 0) -->
                            <!-- / -->
                            <!-- <strike class="opacity-50 text-sm">ac() . number_format($cart->model->sale_price, 2)</strike> -->
                            <!-- endIf -->
                        </td>
                        <!-- <td class="px-5">
                            <span class="text-2xl  text-center">x$cart->qty </span>
                        </td> -->
                        <!-- <td class="font-medium text-xl">
                            <span>ac() $cart->qty * $cart->model->price</span>
                        </td> -->
                    </tr>

                </table>
               </div>


                <div class="py-5 overflow-auto">
                    <table class="w-full">
                        <tbody>
                            <!-- <tr>
                                <td>Subtotal</td>
                                <td class="text-right">{{ ac() . number_format(sub_total(), 2) }}</td>
                            </tr> -->
                            <tr>
                                <td>Discount Amount</td>
                                <td class="text-right">-{{ ac() .number_format(0, 2) }}</td>
                            </tr>
                            <tr class="border-b border-secondary">
                                <td>Tax Amount</td>
                                <td class="text-right">{{ ac() .number_format(0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Order Total</td>
                                <td class="text-right text-xl font-semibold">{{ ac() .number_format($subscription->price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="space-y-5">
                    <h2 class="text-lg md:text-xl font-semibold">Payment</h2>

                    <div class="space-y-5">
                            @if(gs()->payment_stripe_status ?? false)
                                <section class="flex justify-start items-start space-x-5">
                                    <div>
                                        <input '
                                            type="radio"
                                            class="accent-danger w-[20px] h-[20px]"
                                            id="stripe"
                                            wire:model.defer='payment_method'
                                            name="payment_method"
                                            value="stripe"
                                        />
                                    </div>
                                    <label class="space-y-2" for="stripe">
                                        <h3 class="font-medium text-md">{{ gs()->payment_stripe_name }}</h3>
                                        <p>{{ gs()->payment_stripe_description }}</p>
                                    </label>
                                </section>
                            @endIf

                            @if(gs()->payment_paypal_status ?? false)
                            <section class="flex justify-start items-start space-x-5">
                                <div>
                                    <input type="radio"
                                     class="accent-danger w-[20px] h-[20px]"
                                     wire:model.defer='payment_method'
                                     name="payment_method"
                                     value="paypal"
                                     id="paypal" />
                                </div>
                                <label class="space-y-2" for="paypal">
                                    <h3 class="font-medium text-md">{{ gs()->payment_paypal_name }}</h3>
                                    <p>{{ gs()->payment_paypal_description }}</p>
                                </label>
                            </section>
                            @endIf
                        <input type="hidden" name="stripe_plan_id" value="{{ $subscription->stripe_plan_id}}" />
                        <input type="hidden" name="subscription_id" value="{{ $subscription->id}}" />

                        <x-atoms.loading-button text="PLACE ORDER TO SUBSCRIBE" target="submit" class="btn btn-xl rounded-xl btn-danger btn-block" />
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>
