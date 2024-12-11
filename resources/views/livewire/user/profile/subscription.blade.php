
@if($order)
<section class="bg-dark p-5 text-white space-y-10 min-h-[35vh] flex flex-col justify-end">

    <section class="flex items-start md:items-center flex-col space-y-7 md:space-y-0 md:flex-row md:space-x-3 md:justify-between">

        <div class="container">

            <section>
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Subscription Plan:</span>
                        <strong>{{ $order->subscription->name }} </strong>
                    </div>

                    <a href="{{ route('pricing.home') }}" class="font-bold">Upgrade</a>
                </div>

                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Purchased date:</span>
                        <strong>{{ \Carbon\Carbon::parse($order->purchased_date)->format('F d, Y') }}</strong>
                    </div>

                </div>

                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Price:</span>
                        <strong>{{ $order->amount }}</strong>
                    </div>
                </div>
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Tax:</span>
                        <strong>{{ $order->tax_amount }}</strong>
                    </div>
                </div>
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Total:</span>
                        <strong>{{ $order->sub_total }}</strong>
                    </div>
                </div>
            </section>

        </div>
    </section>

</section>
@else
    <section class="bg-dark p-5 text-white space-y-5 min-h-[25vh] flex flex-col justify-middle">
    <div  class="container">
        <p>You have not subscribed any plan.</p>
        <div>
            <a href="{{ route('pricing.home') }}" class="btn btn-md border border-secondary opacity-75"> Subscribe now</a>
        </div>
    </div>
    </section>
@endif


