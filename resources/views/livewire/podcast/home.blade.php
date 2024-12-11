<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Podcast', 'route' => null ]]" />
    <div class="container space-y-7">

        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Popular Podcasts</h2>
                <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o
                    web, precisamos
                    desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que
                    vamos encontrar
                    como desenvolvedores e desenvolvedoras web.</p>
            </header>
        </section>


        <section class="grid sm:grid-cols-2 md:grid-cols-3 gap-7">
            @foreach($podcasts as $podcast)
                <a
                    href="{{ route('podcast.show', ['slug' => $podcast->slug]) }}"
                    style="background-image: url('{{ asset('storage/' .$podcast->thumbnail) }}');"
                    class="shadow-xl relative group transition-all h-[268px] bg-center rounded-xl overflow-hidden">

                        <button>
                            <img src="{{ asset('svg/btn-play.svg') }}" alt=""
                                 class="invisible group-hover:visible absolute top-0 bottom-0 left-0 right-0 m-auto w-[70px] h-[70px] animate-pulse" />
                        </button>

                </a>
            @endforeach
        </section>
        @if ($podcasts->hasMorePages())
        <div class="flex justify-center md:justify-center text-sm">
            <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
                <div class="space-x-1 flex items-center">
                    <button class="btn btn-md border border-secondary opacity-75" wire:click.prevent="loadMore">
                        Load more ...
                    </button>
                </div>
            </div>
        </div>
        @endif
        </section>
    </div>
</div>
