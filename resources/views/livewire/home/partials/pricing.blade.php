<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="md:w-3/4 text-center mx-auto space-y-3">
            <h1 class="font-semibold text-xl md:text-3xl">IT’S EASY TO GET STARTED</h1>
            <p>choose a plan tailored to your needs</p>
            <button class="btn btn-lg border rounded-xl">
                Monthly
            </button>
        </header>


        <section class="grid md:grid-cols-3 gap-10">
            <section class="space-y-5 hover:border-danger hover:border-2 p-5 rounded-xl">
                <header class="py-2 border-b space-y-3">
                    <span>Basic</span>
                    <div>
                        <span class="font-semibold text-3xl">$7.99</span>
                        <span class="font-light">/ month</span>
                    </div>
                </header>
                <ul x-data="{
                    items : [
                        'Ad-supported, all but a few movies and TV shows available, unlimited mobile games',
                        'Watch on 2 supported devices at a time',
                        'Watch in Full HD'
                    ]
                }" class="space-y-5">
                    <template x-for="item in items">
                        <li class="flex items-start justify-start space-x-2">
                            <span class="py-0.5">
                                <input type="checkbox" checked class="accent-white" readonly />
                            </span>
                            <span x-text="item"></span>
                        </li>
                    </template>
                </ul>
                
                <button class="btn border rounded-xl btn-md">
                    Get Started
                </button>
            </section>


            <section class="space-y-5 border-danger border-2 p-5 rounded-xl">
                <header class="py-2 border-b space-y-3">
                    <span>Standard</span>
                    <div>
                        <span class="font-semibold text-3xl">$14.99</span>
                        <span class="font-light">/ month</span>
                    </div>
                </header>
                <ul x-data="{ items : [
                                    'Unlimited ad-free movies, TV shows, and mobile games',
                                    'Watch on 2 supported devices at a time',
                                    'Download on 2 supported devices at a time',
                                    'Watch in Full HD',
                                    'Option to add 1 extra member who doesn\'t live with you'
                                ]}" class="space-y-5">
                    <template x-for="item in items">
                        <li class="flex items-start justify-start space-x-2">
                            <span class="py-0.5">
                                <input type="checkbox" checked class="accent-white" readonly />
                            </span>
                            <span x-text="item"></span>
                        </li>
                    </template>
                </ul>

                <div class="py-7">
                    <button class="btn rounded-xl btn-md btn-danger">
                        Get Started
                    </button>
                </div>
            </section>



            <section class="space-y-5 hover:border-danger hover:border-2 p-5 rounded-xl">
                <header class="py-2 border-b space-y-3">
                    <span>Premium</span>
                    <div>
                        <span class="font-semibold text-3xl">$19.99</span>
                        <span class="font-light">/ month</span>
                    </div>
                </header>
                <ul x-data="{ items : [
                                                'Unlimited ad-free movies, TV shows, and mobile games',
                                                'Watch on 4 supported devices at a time',
                                                'Watch in Ultra HD',
                                                'Download on 6 supported devices at a time',
                                                'Option to add up to 2 extra members who don\'t live with you',
                                                'Netflix spatial audio'
                                            ]}" class="space-y-5">
                    <template x-for="item in items">
                        <li class="flex items-start justify-start space-x-2">
                            <span class="py-0.5">
                                <input type="checkbox" checked class="accent-white" readonly />
                            </span>
                            <span x-text="item"></span>
                        </li>
                    </template>
                </ul>

                <button class="btn border rounded-xl btn-md">
                    Get Started
                </button>
            </section>

        </section>

    </div>
</section>