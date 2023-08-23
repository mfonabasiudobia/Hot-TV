<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex items-center justify-between">
            <h1 class="font-semibold text-xl md:text-2xl">Pedicab Streams</h1>
            <a href="{{ route('pedicab-streams.home') }}" class="flex text-sm items-center space-x-1">
                <span class="inline-block">View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>


        <section class="grid md:grid-cols-3 gap-7">
            <a
                href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url('{{ asset('images/pedicab-image1.png') }}');"
                class="md:col-span-2 h-[384px] rounded-2xl relative group">


                <button class="absolute top-0 bottom-0 m-auto left-0 right-0 md:right-auto md:left-[15%] w-[70px] h-[70px] invisible group-hover:visible">
                    <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                </button>
        
                <div 
                class="md:text-center absolute p-5 right-0 md:top-0 -bottom-[200px] group-hover:bottom-0 flex flex-col justify-center space-y-3 md:space-y-7 md:h-full w-full md:w-[300px] transition-all bg-gradient-to-t from-[#000] md:from-[transparent] to-[rgba(0,0,0,0.5)] md:to-[transparent] shadow-2xl invisible group-hover:visible">
                    <section class="space-y-2">
                        <h2 class="md:racing-sans md:text-6xl ">
                            PEDICAB 
                            TOUR
                        </h2>
                        <div class="md:text-lg font-semibold">SEASONAL TOUR</div>
                    </section>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/user-icon.jpg') }}" alt="" class="w-[34px] h-[34px] rounded-full object-cover" />
                            <span class="font-light">John Doe</span>
                        </div>
                    
                        <span class="font-light">30.5k</span>
                    </div>
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
                
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/user-icon.jpg') }}" alt="" class="w-[34px] h-[34px] rounded-full object-cover" />
                            <span class="font-light">John Doe</span>
                        </div>
                
                        <span class="font-light">30.5k</span>
                    </div>
                </div>
            </a>
        </section>

        <div class="grid md:grid-cols-3 gap-5">
                @foreach (range(1,3) as $item)
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
                                        <img src="{{ asset('images/user-icon.jpg') }}" alt="" class="w-[34px] h-[34px] rounded-full object-cover" />
                                        <span class="font-light">John Doe</span>
                                    </div>

                                    <span class="font-light">30.5k</span>
                                </div>
                            </div>
                        </a>
                @endforeach
        </div>
    </div>
</section>