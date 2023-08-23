<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Celebrity Shout-Outs', 'route' => null ]]" />
    <div class="container space-y-7">

        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Celebrity Shout-Outs</h2>
                <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o
                    web, precisamos
                    desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que
                    vamos encontrar
                    como desenvolvedores e desenvolvedoras web.</p>
            </header>





            <section class="grid md:grid-cols-3 gap-7">
                <a
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                    style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url('{{ asset('images/pedicab-image1.png') }}');"
                    class="md:col-span-2 h-[384px] rounded-2xl relative group">


                    <button
                        class="absolute top-0 bottom-0 m-auto left-0 right-0 md:right-auto md:left-[15%] w-[70px] h-[70px] invisible group-hover:visible">
                        <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                    </button>

                    <div
                        class="invisible group-hover:visible absolute p-5 right-0 md:top-0 -bottom-[200px] group-hover:bottom-0 flex flex-col justify-center space-y-3 md:space-y-7 md:h-full w-full md:w-[400px] transition-all bg-gradient-to-t from-[#000] md:from-[transparent] to-[rgba(0,0,0,0.5)] md:to-[transparent] shadow-2xl">
                        <section class="space-y-2">
                            <h2 class="md:racing-sans md:text-6xl ">
                                Ana Moldova
                            </h2>
                            <div>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um
                                pouco mais sobre o web.</div>
                        </section>
                    </div>
                </a>

                <a
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}" 
                    style="background-image: url('{{ asset('images/stream-02.png') }}');"
                    class="shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">
                    <button>
                        <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                            class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                    </button>

                    <div
                        class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                        <h2 class="font-bold">Pedicab Driver Vloge 13 - Aveneue Street......</h2>
                    </div>
                </a>
            </section>


            <section class="grid md:grid-cols-3 gap-7">

                <a 
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                    style="background-image: url('{{ asset('images/stream-02.png') }}');"
                    class="shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">
                    <button>
                        <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                            class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                    </button>

                    <div
                        class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                        <h2 class="font-bold">Pedicab Driver Vloge 13 - Aveneue Street......</h2>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('images/user-icon.jpg') }}" alt=""
                                    class="w-[34px] h-[34px] rounded-full object-cover" />
                                <span class="font-light">John Doe</span>
                            </div>

                            <span class="font-light">30.5k</span>
                        </div>
                    </div>
                </a>


                <a
                    href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                    style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url('{{ asset('images/pedicab-image1.png') }}');"
                    class="md:col-span-2 h-[384px] rounded-2xl relative group">


                    <button
                        class="absolute top-0 bottom-0 m-auto left-0 right-0 md:right-auto md:left-[15%] w-[70px] h-[70px]">
                        <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                    </button>

                    <div
                        class="absolute p-5 right-0 md:top-0 -bottom-[200px] group-hover:bottom-0 flex flex-col justify-center space-y-3 md:space-y-7 md:h-full w-full md:w-[400px] transition-all bg-gradient-to-t from-[#000] md:from-[transparent] to-[rgba(0,0,0,0.5)] md:to-[transparent] shadow-2xl">
                        <section class="space-y-2">
                            <h2 class="md:racing-sans md:text-6xl ">
                                Ana Moldova
                            </h2>
                            <div>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um
                                pouco mais sobre o web.</div>
                        </section>
                    </div>
                </a>


            </section>


        </section>


        <section class="grid sm:grid-cols-2 md:grid-cols-3 gap-7">
            @foreach (range(1, 6) as $item)
            <a
                href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}" 
                style="background-image: url('{{ asset('images/placeholder-05.png') }}');"
                class="shadow-xl relative group transition-all h-[268px] bg-center rounded-xl overflow-hidden">

                <button>
                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                </button>

                <div
                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                    <h2 class="font-bold">Pedicab Driver Vloge 13 - Aveneue Street......</h2>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/user-icon.jpg') }}" alt=""
                                class="w-[34px] h-[34px] rounded-full object-cover" />
                            <span class="font-light">John Doe</span>
                        </div>

                        <span class="font-light">30.5k</span>
                    </div>
                </div>
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
</div>