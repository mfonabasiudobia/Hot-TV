<div class="py-5 bg-black text-white space-y-5 w-full">
    <x-atoms.breadcrumb :routes="[['title' => 'Shopping Cart', 'route' => null ]]" />
    <div class="container grid lg:grid-cols-3 gap-10 py-16">

        <section class="lg:col-span-2">

            <div class="table-responsive text-left">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="py-3">Product</th>
                            <th class="py-3">Unit Price</th>
                            <th class="py-3">Quantity</th>
                            <th class="py-3">Total Price</th>
                            <th class="py-3"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach (Cart::instance('product')->content() as $cart)
                            <tr x-data="{ quantity : {{ $cart->qty }} }">
                                <td>
                            
                                    <section class="flex items-center space-x-3 w-[320px]">
                                        <img src="{{ file_path($cart->model->images[0]) }}" alt="" class="h-[214px] w-[153px] rounded-xl" />
                            
                                        <div class="space-y-2">
                                            <h2 class="font-semibold text-xl">{{ $cart->model->name }}</h2>
                                            {{-- <div class="text-secondary space-x-3">
                                                <span>2018</span>
                                                <span>ENGLAND</span>
                                                <span>1hr 2min</span>
                                            </div> --}}

                                            @if(isset($cart->model->categories[0]->name))
                                            <button class="btn btn-sm bg-danger bg-opacity-20 border-danger border rounded-xl text-danger">
                                                {{ $cart->model->categories[0]->name }}
                                            </button>
                                            @endIf
                            
                                            
                                        </div>
                                    </section>
                            
                                </td>
                            
                                <td class="font-medium text-xl">
                                    {{ ac() . number_format($cart->model->price) }}
                                </td>
                                <td>
                                    <div class="inline-flex items-center justify-start">
                                        <button class="btn btn-sq btn-xs text-2xl" x-on:click="quantity -= quantity <= 0 ? 0 : 1">-</button>
                                        <span class="text-2xl font-bold px-3 w-[70px] text-center" x-text="quantity">0</span>
                                        <button class="btn btn-sq btn-xs text-2xl" x-on:click="quantity += 1">+</button>
                                    </div>
                                </td>
                            
                                <td class="font-medium text-xl">
                                    $25,78
                                </td>
                                <td>
                                    <button class="text-danger">
                                        <i class="las la-trash text-2xl"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </section>

        <section class="space-y-3">
            <button class="btn btn-xl btn-block flex justify-between items-center bg-danger bg-opacity-20 border-danger border rounded-xl text-danger">
                <span class="flex items-center space-x-3">
                    <img src="{{ asset('images/wallet.svg') }}" alt="">
                    <span>I Have promo code</span>
                </span>

                <i class="las la-caret-right"></i>
            </button>

            <section class="space-y-5 md:p-5">
                <h2 class="text-xl font-semibold">Shopping Summary</h2>
            
                <ul>
                    <li class="flex items-center justify-between">
                        <span>Total</span>
                        <span class="font-semibold text-xl">$42,99</span>
                    </li>
                </ul>
            
                <button class="btn btn-xl rounded-xl btn-danger btn-block">CHECKOUT</button>
            
                <div class="flex justify-center">
                    <a href="#" class="text-danger mx-auto">Back to Shopping</a>
                </div>
            </section>
        </section>
    </div>

    @livewire("home.partials.newsletter")
</div>