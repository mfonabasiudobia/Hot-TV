<div class="py-5 bg-black text-white space-y-7 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => 'About Us', 'route' => null]
            ]" />
    <div class="container space-y-7 pb-10">


        <section class="space-y-7">
            <h1 class="font-semibold text-xl md:text-3xl">About Us</h1>


            <div class="grid grid-cols-2 gap-10">
                <div>
                    <img src="{{ asset('images/ab-us.jpg.webp') }}" alt="">
                </div>

                <div class="space-y-3">
                    <h2 class="font-bold text-xl">World-class library of captivating crime thrillers, addictive dramas, and intriguing mysteries.</h2>

                    <p>Commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Aenean pharetra magna ac placerat vestibulum
                    lectus mauris ultrices eros. Etiam erat velit scelerisque in. Sed libero enim sed faucibus turpis in eu mi bibendum. In
                    dictum non consectetur a erat nam at lectus. Massa ultricies mi quis hendrerit dolor magna.</p>

                    <ul class="space-y-3">
                        <li class="flex space-x-2 items-center">
                            <i class="las la-check-circle text-danger text-2xl"></i>
                            <span>Get Instant access to the US's best series</span>
                        </li>
                        <li class="flex space-x-2 items-center">
                            <i class="las la-check-circle text-danger text-2xl"></i>
                            <span>TV Originals and US premieres</span>
                        </li>
                        <li class="flex space-x-2 items-center">
                            <i class="las la-check-circle text-danger text-2xl"></i>
                            <span>New shows added weekly, so there's always something to watch</span>
                        </li>
                    </ul>
                </div>
            </div>



            <p>Commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Aenean pharetra magna ac placerat vestibulum
            lectus mauris ultrices eros. Etiam erat velit scelerisque in. Sed libero enim sed faucibus turpis in eu mi bibendum. In
            dictum non consectetur a erat nam at lectus. Massa ultricies mi quis hendrerit dolor magna.</p>

        </section>
    </div>


    @livewire("home.partials.newsletter")
</div>