<div class="py-5 bg-black text-white space-y-5">
    <x-atoms.breadcrumb :routes="[
        ['title' => 'Products', 'route' => route('product.home')],
        ['title' => 'Smart Watch External (Digital)', 'route' => null]
    ]" />
    <div class="container space-y-7 py-7" x-data="{ quantity : 0 }">

        <section class="grid md:grid-cols-3 gap-10 py-10">
            <section class="flex justify-center">
                <img src="{{ asset('images/product/single-product-1.png') }}" alt="" />
            </section>

            <section class="md:col-span-2 space-y-7">
                <header class="space-y-7">
                    <h1 class="font-semibold text-xl md:text-3xl">Smart Watch External (Digital)</h1>

                    <section class="flex items-center space-x-5">
                        <span class="text-danger font-bold text-3xl">$894.00</span>
                        <span>(In stock)</span>
                    </section>
                </header>

                <section>
                    <p>Unrestrained and portable active stereo speaker
                    Free from the confines of wires and chords
                    20 hours of portable capabilities
                    Double-ended Coil Cord with 3.5mm Stereo Plugs Included
                    3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</p>
                </section>

                <div class="flex items-center space-x-2">
                    <div class="flex items-center border px-1 rounded-sm">
                        <span class="text-xl font-bold px-7 w-[50px]" x-text="quantity">0</span>
                        <div class="flex flex-col">
                            <button class="btn px-3" x-on:click="quantity += 1">
                                <i class="las la-angle-up text-xs"></i>
                            </button>
                            <button class="btn px-3" x-on:click="quantity -= quantity < 0 ? 0 : 1">
                                <i class="las la-angle-down text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-xl btn-danger">Add To Cart</button>
                </div>

                <ul class="space-y-2">
                    <li>SKU: SW-161-A0</li>
                    <li>Categories: Tablet</li>
                    <li>Tags: Printer , IT</li>
                </ul>

            </section>
        </section>

        <hr />

        <nav class="flex items-center space-x-5 justify-center">
            <button class="btn btn-sm bg-danger bg-opacity-50 text-xl font-semibold text-danger">
                Description
            </button>
            <button class="btn btn-sm text-xl font-semibold">
                Reviews (2)
            </button>
        </nav>

        <section>
            Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail
            along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from
            waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and
            utilitarian design details.
            - Casual unisex fit
            - 64% polyester, 36% polyurethane
            - Water column pressure: 4000 mm
            - Model is 187cm tall and wearing a size S / M
            - Unisex fit
            - Drawstring hood with built-in cap
            - Front placket with snap buttons
            - Ventilation under armpit
            - Adjustable cuffs
            - Double welted front pockets
            - Adjustable elastic string at hempen
            - Ultrasonically welded seams
            This is a unisex item, please check our clothing & footwear sizing guide for specific Rains jacket sizing information.
            RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with
            prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these
            rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and
            foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an
            invitation to explore even in the most mercurial weather.
        </section>

    </div>

    @livewire("home.partials.newsletter")
</div>