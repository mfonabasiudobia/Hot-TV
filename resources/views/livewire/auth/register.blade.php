<div class="min-h-screen flex items-center justify-center py-10"
     style="background-image: url('{{ asset('images/background-image-01.png') }}">
    @if($show == 'register_form')
        <div class="md:w-1/2 lg:w-[500px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
            <header class="space-y-3">
                <h3 class="font-thin text-xl">Welcome !</h3>
                <section class="space-y-2">
                    <h1 class="font-medium text-2xl md:text-3xl">Sign up to Hot TV Station</h1>
                    <p>Your Next Stop for Traveling and streaming Station</p>
                </section>
            </header>
            <form class="grid gap-5" wire:submit.prevent='submit'>
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First name" wire:model.defer="first_name"/>
                        @error('first_name') <span class="error"> {{ $message }}</span> @endError
                    </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last name" wire:model.defer="last_name"/>
                        @error('last_name') <span class="error"> {{ $message }}</span> @endError
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter your email" wire:model.defer="email"/>
                    @error('email') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Enter your username"
                           wire:model.defer="username"/>
                    @error('username') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group" x-data="{ show : false}">
                    <label>Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" placeholder="Enter your Password"
                               wire:model.defer="password"/>
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                    @error('password') <span class="error"> {{ $message }}</span> @endError
                </div>

                <div class="form-group" x-data="{ show : false}">
                    <label>Confirm Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control"
                               placeholder="Confirm your Password"
                               wire:model.defer="password_confirmation"/>
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group flex items-center space-x-2">
                    <input type="checkbox" id="agree" class="accent-danger mt-1 w-[20px] h-[20px]" required/>
                    <label for="agree">I agree to Hot TV Station's terms and conditions, <a href="{{ route('terms') }}"
                                                                                            class="text-danger">Learn
                            more</a></label>
                </div>

            </form>
            <div class="form-group">
                {{--                <x-atoms.loading-button text="Register" target="submit" class="btn btn-lg btn-danger btn-block" />--}}
                <button type="button" class="btn btn-lg btn-danger btn-block" wire:click="next()">Next</button>
            </div>
            <div class="text-center">
                <span class="font-thin">Already have an Account ? </span> <a href="{{ route('login') }}"
                                                                             class="semibold">Login</a>
            </div>
        </div>
    @elseif($show == 'plans')
        <div class="border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5" wire:ignore>
            @if ($plans->isNotEmpty())
                <section class="py-16 bg-black"
                         x-data="{
                        selected_plan:
                        {
                            id: {{ $plans[0]->id }},
                            name: '{{ $plans[0]->name }}',
                            subscriptions: [
                            @foreach($plans[0]->subscriptions as $subscription)
                            {
                                id: {{ $subscription->id }},
                                name: '{!! $subscription->name !!}',
                                price: '${{ $subscription->price }}',
                                is_default: {{ ( $plans[0]->name == 'Annually' && $subscription->name == 'Standard' ) || ( $plans[0]->name == 'Monthly' && $subscription->name == 'Standard') ? 'true' : 'false' }},
                                url: '{{ route('subscription-checkout', $subscription->id) }}',
                                features: [
                                @foreach($subscription->features as $feature)
                                @php
                                    $featureName = addcslashes($feature->description, "'");
                                @endphp
                                    {
                                        id: {{ $feature->id }},
                                        name: '{!! $featureName !!}',
                                    },
                                @endforeach
                                ]
                            },
                            @endforeach
                            ]
                        }
                    }">
                    <div class="container space-y-10 overflow-hidden">
                        <header class="md:w-3/4 text-center mx-auto space-y-3">
                            <h1 class="font-semibold text-xl md:text-3xl">IT’S EASY TO GET STARTED</h1>
                            <p>choose a plan tailored to your needs</p>
                            @foreach($plans as $index => $plan)
                                <button
                                    :class="selected_plan.id == {{ $plan->id }} ? 'btn btn-lg border rounded-xl btn-danger' : 'btn btn-lg border rounded-xl'"
                                    x-data="{ index_button: '{{ $index }}' }"
                                    x-on:click="
                                    selected_plan =
                                        {
                                        id: {{ $plan->id }},
                                        name: '{{ $plan->name }}',
                                        subscriptions: [
                                            @foreach($plan->subscriptions as $subscription)
                                                {
                                                    id: {{ $subscription->id }},
                                                    name: '{!! $subscription->name !!}',
                                                    price: '${{ $subscription->price }}',
                                                    is_default: {{ ( $plan->name == 'Annually' && $subscription->name == 'Standard' ) || ( $plan->name == 'Monthly' && $subscription->name == 'Standard') ? 'true' : 'false' }},
                                                    url: '{{ route('subscription-checkout', $subscription->id) }}',
                                                    features: [
                                                        @foreach($subscription->features as $feature)
                                                        @php
                                                            $featureName = addcslashes($feature->description, "'");
                                                        @endphp
                                                    {
                                                        id: {{ $feature->id }},
                                                        name: '{!! $featureName !!}',
                                                    },
                                                        @endforeach
                                                    ]
                                                },
                                            @endforeach
                                        ]
                                    }
                                    "
                                    :key="Date.now() + Math.floor(Math.random() * 1000000)"
                                >{{ $plan->name }}

                                </button>
                            @endforeach
                        </header>

                        <section class="grid md:grid-cols-3 gap-10">
                            <template x-for="sub in selected_plan.subscriptions" :key="sub.id">
                                <section
                                    :class="sub.is_default ? 'space-y-5 border-danger border-2 p-5 rounded-xl' : 'space-y-5 hover:border-danger hover:border-2 p-5 rounded-xl'">
                                    <header class="py-2 border-b space-y-3">
                                        <span x-text="sub.name"></span>
                                        <div>
                                            <span class="font-semibold text-3xl" x-text="sub.price"></span>
                                            <span class="font-light" x-text="'/' + selected_plan.name"></span>
                                        </div>
                                    </header>
                                    <ul class="space-y-5">
                                        <template x-for="item in sub.features" :key="item.id">
                                            <li class="flex items-start justify-start space-x-2">
                                            <span class="py-0.5">
                                                <input type="checkbox" checked class="accent-white" readonly/>
                                            </span>
                                                <span x-text="item.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                    <button @click="$wire.selectPlan(sub.id)" class="btn border rounded-xl btn-md">
                                        Get Started
                                    </button>
                                </section>
                            </template>
                        </section>
                    </div>
                </section>
        </div>
    @endif
    @else
        <form name="form1" class="container items-center justify-center grid py-7" wire:submit.prevent="submit">
            <section class="md:w-1/2 lg:w-[500px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
                <div class="bg-dark rounded-2xl p-5 space-y-5">
                    <h2 class="text-xl md:text-2xl font-semibold">Order Details</h2>

                    <div class="overflow-auto">
                        <table class="w-full">
                            <tr>
                                <td>
                                    <section class="flex items-center space-x-3 w-[320px]">
                                        <div class="space-y-2">
                                            <h2 class="font-semibold text-xl">{{ $subscription->name }}</h2>
                                        </div>
                                    </section>
                                </td>
                                <td class="font-medium text-xl">
                                    <span>{{ ac() . number_format($subscription->price, 2) }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="py-5 overflow-auto">
                        <table class="w-full">
                            <tbody>
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
                                <td class="text-right text-xl font-semibold">{{ ac() . number_format($subscription->price, 2) }}</td>
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
                                        <input type="radio"
                                        class="accent-danger w-[20px] h-[20px]"
                                        id="stripe"
                                        wire:model.defer='paymentMethod'
                                        name="paymentMethod"
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
                                               wire:model.defer='paymentMethod'
                                               name="paymentMethod"
                                               value="paypal"
                                               id="paypal"/>
                                    </div>
                                    <label class="space-y-2" for="paypal">
                                        <h3 class="font-medium text-md">{{ gs()->payment_paypal_name }}</h3>
                                        <p>{{ gs()->payment_paypal_description }}</p>
                                    </label>
                                </section>
                            @endIf
                            <input type="hidden" name="stripe_plan_id" value="{{ $subscription->stripe_plan_id}}"/>
                            <input type="hidden" name="subscription_id" value="{{ $subscription->id}}"/>
                            <x-atoms.loading-button text="PLACE ORDER TO SUBSCRIBE" target="submit"
                                                    class="btn btn-xl rounded-xl btn-danger btn-block"/>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    @endif
</div>
