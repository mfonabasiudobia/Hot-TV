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
        </section>


        <section class="grid sm:grid-cols-2 md:grid-cols-3 gap-7">
            @foreach($shoutouts as $shoutout)
            <a
                href="{{ route('shoutout.show', ['slug' => $shoutout->slug]) }}"
                style="background-image: url('{{ asset('storage/' .$shoutout->thumbnail) }}');"
                class="shadow-xl relative group transition-all h-[268px] bg-center rounded-xl overflow-hidden">

                @if($shoutout->media_type == 'video')
                <button>
                    <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                        class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                </button>

                @endif

                <div
                    class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                    <h2 class="font-bold">{!! $shoutout->description !!} </h2>
                </div>
            </a>
            @endforeach
        </section>


        <div class="flex justify-center md:justify-center text-sm">
            <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
{{--                <span class="opacity-60">Showing 10 from 10 data</span>--}}

                <div class="space-x-1 flex items-center">
{{--                    <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">--}}
{{--                        <i class="las la-angle-double-left"></i>--}}
{{--                        <span>Previous</span>--}}
{{--                    </a>--}}

                    <button class="space-x-1 btn btn-sm bg-danger rounded-xl" wire:click.prevent="loadMore">
                        Load more ...
                    </button>

{{--                    <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">--}}
{{--                        <span>Load more...</span>--}}
{{--                        --}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
        </section>
    </div>
</div>
