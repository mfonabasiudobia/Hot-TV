@if ($plans->isNotEmpty())

<section class="py-16 bg-black" x-data="{
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
                        url_text: '{{ $plans[0]->trail == 1 ? 'Start '. $plans[0]->trail_period. '-Day Free Trail' : 'Start' }}',
                        url: '{{ $plans[0]->trail ? route('register', $subscription->id) : route('register', ['planId' => $subscription->id ]) }}',
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
                <button :class="selected_plan.id == {{ $plan->id }} ? 'btn btn-lg border rounded-xl btn-danger' : 'btn btn-lg border rounded-xl'" x-data="{ index_button: '{{ $index }}' }"
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
                                url_text: '{{ $plan->trail == 1 ? 'Start '. $plan->trail_period. '-Day Free Trail' : 'Start' }}',
                                url: '{{ $plan->trail == 1 ? route('register', $subscription->id) : route('register', ['planId' => $subscription->id ]) }}',
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
                <section :class="sub.is_default ? 'space-y-5 border-danger border-2 p-5 rounded-xl' : 'space-y-5 hover:border-danger hover:border-2 p-5 rounded-xl'">
                    <header class="py-2 border-b space-y-3">
                        <span x-text="sub.name"></span>
                        <div>
                            <span class="font-semibold text-3xl" x-text="sub.price"></span>
                            <span class="font-light" x-text="'/' + selected_plan.name"></span>
                        </div>
                    </header>
                    <ul class="space-y-5">
                        <template x-for="item in sub.features"  :key="item.id">
                            <li class="flex items-start justify-start space-x-2">
                                <span class="py-0.5">
                                    <input type="checkbox" checked class="accent-white" readonly />
                                </span>
                                <span x-text="item.name"></span>
                            </li>
                        </template>
                    </ul>
                    @if(gs()->payment_stripe_status == 1 || gs()->payment_paypal_status == 1)
                        <a :href="sub.url" class="btn border rounded-xl btn-md" x-text="sub.url_text"></a>
                    @endif
                </section>
                </template>
            </section>
    </div>
</section>
@endif

@push('footer')
    <script>
        $(function() {
            console.log('Subscription plan working');
        });
    </script>
@endpush
