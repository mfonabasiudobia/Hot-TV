<div class="py-5 bg-black text-white">
    <div class="container space-y-7">
        <x-atoms.breadcrumb :routes="[
            ['title' => 'Tv Shows', 'route' => route('tv-shows.home') ],
            ['title' => 'Christian show - Talking about Jesus', 'route' => null]
        ]" 
        />

        <section class="grid md:grid-cols-3 gap-10">
            <div class="md:col-span-2 space-y-7">
                <img src="{{ asset('images/frameVideo.png') }}" alt="">


                <header class="flex items-center justify-between">
                    <div class="space-y-1">
                        <h2 class="font-semibold text-xl">Christian show - Talking about Jesus.</h2>
                        <p>Published on June 4, 2020</p>
                    </div>

                    <div class="flex flex-col items-end space-y-5">
                        <button>
                            <img src="{{ asset('svg/3-dots-horizontal.svg') }}" alt="" />
                        </button>

                        <div class="flex items-center space-x-3">
                            <div>
                                <i class="lar la-eye"></i>
                                <span>567k viewers</span>
                            </div>

                            <span>167min</span>
                        </div>
                    </div>
                </header>
                <section class="space-y-5">
                    <section class="space-y-7 text-sm">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                            magna
                            aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis
                            aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem
                            aperiam,
                            eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                            ipsam
                            voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                            voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                            adipisci velit,
                            sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim
                            ad minima
                            veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                            consequatur? Quis
                            autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui
                            dolorem
                            eum fugiat quo voluptas nulla pariatur?</p>
                    </section>
                    
                    <div class="flex justify-center">
                        <button class="text-sm text-[#0012B6] flex items-center">
                            <span>Read More</span>
                            <img src="{{ asset('svg/arrow-circle-down.svg') }}" alt="">
                        </button>
                    </div>
                </section>


                <section class="space-y-5">
                    <h1 class="font-semibold text-2xl">Cast</h1>
                    <section class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-10">
                        <div class="flex space-x-2">
                            <img src="{{ asset('images/placeholder-04.png') }}" alt="" />
                            <div>
                                <h3 class="font-semibold text-xl">Oliver Jons</h3>
                                <span class="opacity-60 text-sm">Main Character (as Roberto)</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <img src="{{ asset('images/placeholder-04.png') }}" alt="" />
                            <div>
                                <h3 class="font-semibold text-xl">Jennifer Law</h3>
                                <span class="opacity-60 text-sm">as Cindy Mamora</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <img src="{{ asset('images/placeholder-04.png') }}" alt="" />
                            <div>
                                <h3 class="font-semibold text-xl">Kevin Klee</h3>
                                <span class="opacity-60 text-sm">as Mancii</span>
                            </div>
                        </div>
                    </section>
                </section>
            </div>


            <div class="space-y-7">

                <section class="bg-dark p-5 rounded-2xl">
                    <img src="{{ asset('images/coverFilm-02.png') }}" alt="" />
                </section>

                <section class="bg-dark p-5 rounded-2xl space-y-5">
                    <h3 class="text-right opacity-50 text-sm space-x-2">
                        <span>12 Episode</span>

                        <i class="las la-caret-up"></i>
                    </h3>
                
                    <section class="overflow-y-auto h-[70vh] space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        @foreach ([1,2,3,4,5,6,7,8,9,10,11,12] as $item)
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/play.png') }}" alt="" class="h-[80px]" />
                            <div>
                                <h2 class="font-semibold">THDST-S1EP1</h2>
                                <div class="opacity-50 text-sm">
                                    <span>36min</span>
                                    <span>Published on June 29, 2020</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </section>
                </section>


                <section class="bg-dark p-5 space-y-3 rounded-2xl">
                    <h3 class="font-semibold text-lg">Share</h3>
                
                    <div class="flex flex-wrap  text-sm">
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/facebook.png') }}" alt="" class="h-[40px]" />
                        </a>
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/youtube.png') }}" alt="" class="h-[40px]" />
                        </a>
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/twitter.png') }}" alt="" class="h-[40px]" />
                        </a>
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/linkedIn.png') }}" alt="" class="h-[40px]" />
                        </a>
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/pinterest.png') }}" alt="" class="h-[40px]" />
                        </a>
                        <a href="#" class="mr-2 mb-1">
                            <img src="{{ asset('images/custom-link.png') }}" alt="" class="h-[40px]" />
                        </a>
                    </div>
                </section>


                <section class="bg-dark p-5 space-y-3 rounded-2xl">
                    <h3 class="font-semibold text-lg">Tags</h3>

                    <div class="flex flex-wrap  text-sm">
                        <a href="#" class="mr-2 mb-1">#action</a>
                        <a href="#" class="mr-2 mb-1">#advanture</a>
                        <a href="#" class="mr-2 mb-1">#survival</a>
                        <a href="#" class="mr-2 mb-1">#wars</a>
                        <a href="#" class="mr-2 mb-1">#1980</a>
                        <a href="#" class="mr-2 mb-1">#history</a>
                        <a href="#" class="mr-2 mb-1">#documentary</a>
                    </div>
                </section>
            </div>
        </section>
    </div>




    @livewire("home.partials.partners")


    @livewire("home.partials.newsletter")
</div>