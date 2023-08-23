<div class="py-5 bg-black text-white space-y-5">
    <x-atoms.breadcrumb :routes="[['title' => 'Tv Shows', 'route' => null ]]" />
    <div class="container space-y-7">

        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Our Tv Shows</h2>
                <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o
                    web, precisamos
                    desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que
                    vamos encontrar
                    como desenvolvedores e desenvolvedoras web.</p>
            </header>

            <div class="rounded-2xl px-7 hidden md:flex justify-between items-center bg-dark text-sm py-3">
                <button class="flex items-center space-x-3">
                    <span>Shows Title</span>

                    <img src="{{ asset('svg/ic_sort.svg') }}" alt="">
                </button>

                <div class="flex items-center space-x-7">
                    <a href="#">Today</a>

                    <a href="#">This Week</a>

                    <a href="#">This Month</a>

                    <a href="#" class="flex items-center space-x-1"><i class="las la-sort-amount-down-alt text-xl"></i>
                        <span>Newest</span></a>
                </div>
            </div>

            <section class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

                @foreach ([1,2,3,4,5,6,7,8,9,10,11,12] as $item)
                <a class="relative space-y-5 p-5 bg-dark rounded-xl group"
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}">
                    <img src="{{ asset('images/people-on-point.png') }}" alt=""
                        class="rounded-lg group-hover:scale-125 transition-all" />

                    <div class="space-y-3">
                        <h2 class="text-center font-semibold">SECONDS</h2>

                        <div class="flex items-center justify-between opacity-60 text-sm">
                            <span>30.2k views</span>
                            <span>1hr 2min</span>
                        </div>
                    </div>

                    <span
                        class="rounded-b-lg bg-danger py-1 px-5 absolute left-1/2 transform -translate-x-1/2 top-0">HORROR</span>
                </a>
                @endforeach

            </section>


            <div class="flex justify-center md:justify-end text-sm">
                <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
                    <span class="opacity-60">Showing 10 from 10 data</span>

                    <div class="space-x-1 flex items-center">
                        <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                            <i class="las la-angle-double-left"></i>
                            <span>Previous</span>
                        </a>

                        <a href="#" class="space-x-1 btn btn-sm bg-danger rounded-xl">
                            1
                        </a>

                        <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                            <span>Next</span>
                            <i class="las la-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>




    @livewire("home.partials.partners")


    @livewire("home.partials.newsletter")
</div>