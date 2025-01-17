<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Pedicab Streams', 'route' => null ]]" />
    <div class="container space-y-7">
        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Pedicab Streams</h2>
                <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web, precisamos
                desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos encontrar
                como desenvolvedores e desenvolvedoras web.</p>
            </header>
<!--
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
                    class="invisible group-hover:visible md:text-center absolute p-5 right-0 md:top-0 -bottom-[200px] group-hover:bottom-0 flex flex-col justify-center space-y-3 md:space-y-7 md:h-full w-full md:w-[300px] transition-all bg-gradient-to-t from-[#000] md:from-[transparent] to-[rgba(0,0,0,0.5)] md:to-[transparent] shadow-2xl">
                    <section class="space-y-2">
                        <h2 class="md:racing-sans md:text-6xl ">
                            PEDICAB
                            TOUR
                        </h2>
                        <div class="md:text-lg font-semibold">SEASONAL TOUR</div>
                    </section>

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


            <a href="{{ route('tv-shows.show', ['slug' => 'open-tv-show']) }}"
                style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url('{{ asset('images/pedicab-image1.png') }}');"
                class="md:col-span-2 h-[384px] rounded-2xl relative group">


                <button
                    class="absolute top-0 bottom-0 m-auto left-0 right-0 md:right-auto md:left-[15%] w-[70px] h-[70px] invisible group-hover:visible">
                    <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                </button>

                <div
                    class="invisible group-hover:visible md:text-center absolute p-5 right-0 md:top-0 -bottom-[200px] group-hover:bottom-0 flex flex-col justify-center space-y-3 md:space-y-7 md:h-full w-full md:w-[300px] transition-all bg-gradient-to-t from-[#000] md:from-[transparent] to-[rgba(0,0,0,0.5)] md:to-[transparent] shadow-2xl">
                    <section class="space-y-2">
                        <h2 class="md:racing-sans md:text-6xl ">
                            PEDICAB
                            TOUR
                        </h2>
                        <div class="md:text-lg font-semibold">SEASONAL TOUR</div>
                    </section>

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


        </section> -->
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px">
                    <li class="me-2">
                        <a href="#" wire:click="selectTab('live-streams')" class="{{ $activeTab === 'live-streams' ? 'border-b-2' : '' }} inline-block p-4 text-blue-600  border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500">
                            Live Streams
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" wire:click="selectTab('ended-streams')" class="{{ $activeTab === 'ended-streams' ? 'border-b-2' : '' }} inline-block p-4 text-blue-600  border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500" aria-current="page">
                            Ended Streams
                        </a>
                    </li>
                </ul>
            </div>

            <section class="{{ $activeTab === 'live-streams' ? 'block' : 'hidden' }}">
                <section class="grid sm:grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach ($liveStreamsData as $item)
                        @if (!$item['is_stream_blocked'])
                            <a href="{{ route('pedicab-streams.show', $item['id']) }}"
                                style="background-size: cover; background-repeat: no-repeat; background-image: url('{{ $item['stream_thumbnail'] ? 'storage/' . $item['stream_thumbnail'] : 'https://placehold.co/600x400' }}')"
                                class="shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">

                                <button class="absolute top-1 p-2 bg-secondary b-r-2">
                                    <span class="text-danger">&bull;</span>
                                    Live
                                </button>

                                <button>
                                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                                </button>

                                <div
                                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                                    <div class="flex justify-between">
                                        <h2 class="font-bold">{{$item['customer']['username']}} - {{$item['street_name']}}</h2>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item['customer']['avatar_url'] ?? '' }}" alt=""
                                                class="w-[34px] h-[34px] rounded-full object-cover" />
                                            <span class="font-light">{{$item['customer']['username']}}</span>
                                        </div>

                                        <span class="font-light">watching: {{$item['watching']}}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </section>

            </section>

            <section class="{{ $activeTab === 'ended-streams' ? 'block' : 'hidden' }}">
                <section class="grid sm:grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach ($endedStreamsData as $item)
                        @if (!$item['is_stream_blocked'])
                            <a href="{{ route('pedicab-streams.show', $item['id']) }}"
                                style="background-size: cover; background-repeat: no-repeat; background-image: url('{{ $item['stream_thumbnail'] ? 'storage/' . $item['stream_thumbnail'] : 'https://placehold.co/600x400' }}')"
                                class="shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">

                                <button class="absolute top-1 p-2">
                                    @if($item['stream_status'] === 'streaming')
                                        <i class="fas fa-eye"></i>
                                    @else
                                        <i class="fas fa-eye-slash"></i>
                                    @endif
                                </button>

                                <button>
                                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                                </button>

                                <div
                                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                                    <div class="flex justify-between">
                                        <h2 class="font-bold">{{$item['customer']['username']}} - {{$item['street_name']}}</h2>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item['customer']['avatar_url'] ?? ''}}" alt=""
                                                class="w-[34px] h-[34px] rounded-full object-cover" />
                                            <span class="font-light">{{$item['customer']['username']}}</span>
                                        </div>

                                        <span class="font-light">views: {{$item['views']}}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </section>

            </section>
            <!-- <div class="flex justify-center md:justify-end text-sm">
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
            </div> -->
        </section>
    </div>
</div>
