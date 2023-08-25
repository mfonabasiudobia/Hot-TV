<div class="py-5 bg-black text-white space-y-5 w-full">
    <x-atoms.breadcrumb :routes="[['title' => 'Checkout', 'route' => null ]]" />
    <div class="container grid md:grid-cols-2 gap-10 py-7">

        <section class="space-y-7">
            <header class="flex items-center justify-between">
                <h2 class="text-xl md:text-2xl font-semibold">Shipping Details</h2>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" class="accent-danger w-[30px]" id="agree" checked>
                    <label for="agree">Save</label>
                </div>
            </header>
            <form class="grid grid-cols-2 gap-5">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="First Name" wire:model.defer="first_name" />
                </div>
            
               <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Last Name" wire:model.defer="last_name" />
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" placeholder="Email Address" wire:model.defer="email" />
                </div>

                <div class="form-group">
                    <label>Mobile Phone Number</label>
                    <input type="text" class="form-control" placeholder="Mobile Phone Number" wire:model.defer="mobile_number" />
                </div>

                <div class="form-group md:col-span-2">
                    <label>Address</label>
                    <input type="text" class="form-control" placeholder="Address" wire:model.defer="address" />
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" placeholder="Country" wire:model.defer="country" />
                </div>

                <div class="form-group">
                    <label>Postcode/ZIP</label>
                    <input type="text" class="form-control" placeholder="Postcode/ZIP" wire:model.defer="post_code" />
                </div>

                <div class="form-group">
                    <label>Town/City</label>
                    <input type="text" class="form-control" placeholder="Town/City" wire:model.defer="city" />
                </div>
            </form>
        </section>

        <section>
            <div class="bg-dark rounded-2xl p-5 space-y-5">
                <h2 class="text-xl md:text-2xl font-semibold">Order Details</h2>

                <table class="w-full">
                    <tr x-data="{ quantity : 0 }">
                        <td>
                            <section class="flex items-center space-x-3">
                                <img src="{{ asset('images/placeholder-04.png') }}" alt="" />
                
                                <div class="space-y-2">
                                    <h2 class="font-semibold text-xl">Terrible Madness</h2>
                                    <div class="text-secondary">
                                    </div>
                
                                    <button
                                        class="btn btn-sm bg-danger bg-opacity-20 border-danger border rounded-xl text-danger">ACTION
                                        SERIES</button>
                                </div>
                            </section>
                        </td>
                
                        <td class="font-medium text-xl">
                            xl
                        </td>
                
                        <td class="font-medium text-xl">
                            $25,78
                        </td>
                    </tr>
                </table>


                <div class="py-5">
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right">$25,78</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td class="text-right">Free Shipping</td>
                            </tr>
                            <tr class="border-b border-secondary">
                                <td>Tax</td>
                                <td class="text-right">$4.00</td>
                            </tr>

                            <tr>
                                <td class="font-medium">Order Total</td>
                                <td class="text-right text-xl font-semibold">$29,78</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="space-y-5">
                    <h2 class="text-lg md:text-xl font-semibold">Payment</h2>

                    <div class="space-y-5">
                        <section class="flex justify-start items-start space-x-5">
                            <div>
                                <input type="checkbox" class="accent-danger w-[20px] h-[20px]" id="stripe" checked />
                            </div>
                            <label class="space-y-2" for="stripe">
                                <h3 class="font-medium text-md">Stripe</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore e</p>
                            </label>
                        </section>

                        <section class="flex justify-start items-start space-x-5">
                            <div>
                                <input type="checkbox" class="accent-danger w-[20px] h-[20px]" id="paypal" />
                            </div>
                            <label class="space-y-2" for="paypal">
                                <h3 class="font-medium text-md">Paypal</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore e</p>
                            </label>
                        </section>


                        <button class="btn btn-xl rounded-xl btn-danger btn-block">PLACE ORDER</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @livewire("home.partials.newsletter")
</div>