@php
    $streams = \App\Models\Ride::orderBy('id', 'desc')->get()->take(9);
@endphp
<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <header class="flex items-center justify-between">
            <h1 class="font-semibold text-xl md:text-2xl">{{ $shortcode->title }}</h1>
            <a href="{{ route('pedicab-streams.home', 1) }}" class="flex text-sm items-center space-x-1">
                <span class="inline-block">View more</span>
                <img src="{{ asset('svg/arrow-circle-right.svg') }}" alt="" />
            </a>
        </header>

        <div class="grid md:grid-cols-3 gap-5">
            @foreach ($streams as $item)
                @if (!$item->is_stream_blocked)
                    <a href="{{ route('pedicab-streams.show', $item->id) }}"
                        style="background-image: url('{{ asset("images/stream-02.png") }}');"
                        class="shadow-xl relative group transition-all h-[384px] bg-center rounded-xl overflow-hidden">

                        <button class="absolute top-1 p-2">
                            @if($item->stream_status === 'streaming')
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
                                <h2 class="font-bold">{{$item->customer->username}} - {{$item->street_name}}</h2>
                                <div>
                                    watching: {{$item->watching}}
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $item->customer->avatar_url }}" alt=""
                                        class="w-[34px] h-[34px] rounded-full object-cover" />
                                    <span class="font-light">{{$item->customer->username}}</span>
                                </div>

                                <span class="font-light">{{$item->views}}</span>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
