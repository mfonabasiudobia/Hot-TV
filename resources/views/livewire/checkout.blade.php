<div class="py-5 bg-black text-white space-y-5">
    <x-atoms.breadcrumb :routes="[['title' => 'Checkout', 'route' => null ]]" />
    <form class="container grid md:grid-cols-2 gap-10 py-7" wire:submit.prevent="submit">

        <section class="space-y-7">
            <header class="flex items-center justify-between">
                <h2 class="text-xl md:text-2xl font-semibold">Shipping Details</h2>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" class="accent-danger w-[30px]" id="agree" wire:model.defer='can_save'>
                    <label for="agree">Save</label>
                </div>
            </header>
            <section class="grid sm:grid-cols-2 gap-5">
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
                    <input type="text" class="form-control" placeholder="Email Address" wire:model.defer="email" />
                    @error('email') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" placeholder="Mobile Number" wire:model.defer="mobile_number" />
                    @error('mobile_number') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group md:col-span-2">
                    <label>Address</label>
                    <input type="text" class="form-control" placeholder="Address" wire:model.defer="address" />
                    @error('address') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" placeholder="Country" wire:model.defer="country" />
                    @error('country') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Postcode/ZIP</label>
                    <input type="text" class="form-control" placeholder="Postcode/ZIP" wire:model.defer="post_code" />
                    @error('post_code') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Town/City</label>
                    <input type="text" class="form-control" placeholder="Town/City" wire:model.defer="city" />
                    @error('city') <span class="error"> {{ $message }}</span> @endError
                </div>
            </section>
        </section>

        <section class="overflow-hidden">
            <div class="bg-dark rounded-2xl p-5 space-y-5">
                <h2 class="text-xl md:text-2xl font-semibold">Order Details</h2>

               <div class="overflow-auto">
                <table class="w-full">
                    @foreach (Cart::instance('product')->content() as $cart)
                    <tr>
                        <td>
                            <section class="flex items-center space-x-3 w-[320px]">
                                <img src="{{ file_path($cart->model->images[0]) }}" alt="" class="h-[100px] w-auto rounded-xl" />
                
                                <div class="space-y-2">
                                    <h2 class="font-semibold text-xl">{{ $cart->model->name }}</h2>
                                </div>
                            </section>
                        </td>
                        <td class="font-medium text-xl">
                            <span>{{ ac() . number_format($cart->model->price, 2) }}</span>
                
                            @if($cart->model->sale_price > 0)
                            /
                            <strike class="opacity-50 text-sm">{{ ac() . number_format($cart->model->sale_price, 2)}}</strike>
                            @endIf
                        </td>
                        <td class="px-5">
                            <span class="text-2xl  text-center">x{{ $cart->qty }}</span>
                        </td>
                        <td class="font-medium text-xl">
                            <span>{{ ac() }}{{ $cart->qty * $cart->model->price }}</span>
                        </td>
                    </tr>
                    @endforeach
                </table>
               </div>


                <div class="py-5 overflow-auto">
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right">{{ ac() . number_format(sub_total(), 2) }}</td>
                            </tr>
                            <tr>
                                <td>Discount Amount</td>
                                <td class="text-right">-{{ ac() . number_format(discount_amount(), 2) }}</td>
                            </tr>
                            <tr class="border-b border-secondary">
                                <td>Tax Amount</td>
                                <td class="text-right">{{ ac() . number_format(tax_amount(), 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Order Total</td>
                                <td class="text-right text-xl font-semibold">{{ ac() . number_format(total_amount(), 2) }}</td>
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
                                            type="checkbox"
                                            class="accent-danger w-[20px] h-[20px]" 
                                            id="stripe" 
                                            {{ gs()->default_payment_method == 'stripe' ? 'checked' : '' }} 
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
                                    <input type="checkbox" class="accent-danger w-[20px] h-[20px]" id="paypal" {{ gs()->default_payment_method == 'paypal' ? 'checked' : '' }} />
                                </div>
                                <label class="space-y-2" for="paypal">
                                    <h3 class="font-medium text-md">{{ gs()->payment_paypal_name }}</h3>
                                    <p>{{ gs()->payment_paypal_description }}</p>
                                </label>
                            </section>
                            @endIf

                        <x-atoms.loading-button text="PLACE ORDER" target="submit" class="btn btn-xl rounded-xl btn-danger btn-block" />
                    </div>
                </div>
            </div>
        </section>
    </form>

    @livewire("home.partials.newsletter")
</div>