<section>
    <x-loading />
    <div class="py-5 bg-black text-white space-y-5 w-full">
        <x-atoms.breadcrumb :routes="[['title' => 'Shopping Cart', 'route' => null ]]" />
        <div class="container grid lg:grid-cols-3 gap-10 py-16">

            <section class="lg:col-span-2">


                @if(Cart::instance('product')->count() > 0)

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
                                        <img src="{{ file_path($cart->model->images[0]) }}" alt=""
                                            class="h-[100px] w-auto rounded-xl" />

                                        <div class="space-y-2">
                                            <h2 class="font-semibold text-xl">{{ $cart->model->name }}</h2>
                                            {{-- <div class="text-secondary space-x-3">
                                                <span>2018</span>
                                                <span>ENGLAND</span>
                                                <span>1hr 2min</span>
                                            </div> --}}

                                            {{-- @if(isset($cart->model->categories[0]->name))
                                            <button
                                                class="btn btn-sm bg-danger bg-opacity-20 border-danger border rounded-xl text-danger">
                                                {{ $cart->model->categories[0]->name }}
                                            </button>
                                            @endIf --}}
                                        </div>
                                    </section>
                                </td>
                                <td class="font-medium text-xl">
                                    <span>{{ ac() . number_format($cart->model->price, 2) }}</span>

                                    @if($cart->model->sale_price > 0)
                                    /
                                    <strike class="opacity-50">{{ ac() . number_format($cart->model->sale_price, 2)}}</strike>
                                    @endIf
                                </td>
                                <td>
                                    <div class="inline-flex items-center justify-start">
                                        <button class="btn btn-sq btn-xs text-2xl"
                                        x-on:click="() => {
                                                    quantity -= quantity <= 0 ? 0 : 1
                                                    $wire.lessFromCart({{ $cart->model }}, quantity);
                                                }">-</button>
                                        <span class="text-2xl font-bold px-3 w-[70px] text-center"
                                            x-text="quantity">0</span>
                                        <button class="btn btn-sq btn-xs text-2xl" x-on:click="() => {
                                                    quantity += 1;
                                                    $wire.addToCart({{ $cart->model }}, quantity);
                                                }">+</button>
                                    </div>
                                </td>
                                <td class="font-medium text-xl">
                                    {{ ac() }} <span x-text="quantity * {{ $cart->model->price }}"></span>
                                </td>
                                <td>
                                    <button class="text-danger" wire:click.prevent="removeFromCart('{{ $cart->rowId }}')">
                                        <i class="las la-trash text-2xl"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                @else
                    <div
                        class="flex flex-col justify-center items-center space-y-3 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-7">
                        <h1 class="text-xl md:text-2xl font-bold">Nothing Found</h1>
                        <p>No Items has been found. <a href="{{ route('merchandize.home') }}" class="text-danger">Click here</a> to continue shopping</p>
                    </div>
                @endIf

            </section>

            <section class="space-y-3">
                {{-- <button
                    class="btn btn-xl btn-block flex justify-between items-center bg-danger bg-opacity-20 border-danger border rounded-xl text-danger">
                    <span class="flex items-center space-x-3">
                        <img src="{{ asset('images/wallet.svg') }}" alt="">
                        <span>I Have promo code</span>
                    </span>

                    <i class="las la-caret-right"></i>
                </button> --}}

                <section class="space-y-5 md:p-5">
                    <h2 class="text-xl font-semibold">Shopping Summary</h2>

                    <ul class="space-y-3">
                        <li class="flex items-center justify-between">
                            <span>Sub Total</span>
                            <span class="font-semibold text-xl">{{ ac() . number_format(sub_total(), 2)  }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Discount Amount</span>
                            <span class="font-semibold text-xl">-{{ ac() . number_format(discount_amount(), 2) }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Tax Amount</span>
                            <span class="font-semibold text-xl">{{ ac() . number_format(tax_amount(), 2) }}</span>
                        </li>

                        <li class="flex items-center justify-between">
                            <span>Total Amount</span>
                            <span class="font-semibold text-xl">{{ ac() . number_format(total_amount(), 2) }}</span>
                        </li>
                    </ul>

                    <a href="{{ route('cart.checkout') }}" class="btn btn-xl rounded-xl btn-danger btn-block">CHECKOUT</a>

                    <div class="flex justify-center">
                        <a href="{{ route('merchandize.home') }}" class="text-danger mx-auto">Back to Shopping</a>
                    </div>
                </section>
            </section>
        </div>

        @livewire("home.partials.newsletter")
    </div>
</section>
