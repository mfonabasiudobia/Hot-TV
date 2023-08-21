<div class="py-5 bg-black text-white space-y-7">
    <div class="container space-y-7">
        <x-atoms.breadcrumb :routes="[
            ['title' => 'FAQ', 'route' => null]
        ]" />

        <section class="space-y-7">
            <header class="md:w-3/4 text-center mx-auto space-y-3">
                <span class="barlow-font text-xl md:text-3xl">Pre-Sale Questions</span>
                <h1 class="font-semibold text-xl md:text-3xl">Frequently Asked Questions</h1>
                <p class="text-[#7E7E7E]">Here are some frequently asked questions about our garage door services that we provide all across Northern California</p>
            </header>



            <section class="space-y-5 text-secondary">
                <div class="space-y-3 border border-secondary p-3" x-data="{ show : true}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">What kind of garage door services do you offer?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear. But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>


                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">How much do your services cost?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>

                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">Do you offer emergency garage door services?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>

                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">How often should I have my garage door serviced?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>


                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">What should I do if my garage door is stuck or won't open?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>

                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">Are your technicians licensed and insured?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>

                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">How soon can I get an appointment for garage door service?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>

                <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
                    <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                        <h2 class="text-danger">What payment options do you accept?</h2>
                        <button class="min-w-[45px] min-h-[45px] text-danger">
                            <i class="las la-angle-down"></i>
                        </button>
                    </header>
                    <p x-show="show">
                        The cost of our garage door services depends on various factors, such as the type of service needed (repair,
                        maintenance, installation, etc.), the size of the garage door, and the extent of the damage or wear and tear.
                        But
                        overall, we offer competitive pricing on all of our services. Contact us to get a free quote today.
                    </p>
                </div>
            
            </section>

        </section>
    </div>


    @livewire("home.partials.newsletter")
</div>