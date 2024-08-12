<section class="py-16 bg-black">
    <div class="container space-y-10 overflow-hidden">
        <section class="grid md:grid-cols-2 gap-10">

            <section class="space-y-10">
                <header class="space-y-3">
                    <h1 class="font-semibold text-xl md:text-3xl">{{ $shortcode->title }}</h1>
                    <p>{!! $shortcode->description !!}</p>
                </header>

                @php($podcast = \App\Models\Podcast::latest()->first())
                <section class="relative rounded-xl overflow-hidden">
                    <div class="bg-danger flex flex-col md:flex-row justify-between items-start md:space-x-2 p-5">
                        <div class="flex space-x-3">
                            <img src="{{ asset('images/video-file.svg') }}" alt="">
                            <section>
                                <h2 class="font-semibold text-xl">{{ $podcast->title }}</h2>
                                <div class="flex items-center space-x-3 text-sm">
                                    <span>26-07-2023</span>
                                    <span>ENGLISH</span>
                                    <span>1hr 2min</span>
                                </div>
                            </section>
                        </div>

                        {{-- <button
                            class="invisible md:visible btn border rounded-xl py-1 px-2 text-3xl text-danger bg-white hover:text-white">
                            <i class="las la-heart text-danger"></i>
                        </button> --}}
                    </div>
                    <div class="relative">
                        <img src="{{ file_path($podcast->thumbnail) }}" alt="" class="h-[266px] w-full object-cover" />
                        <a href="{{ route('podcast.show', ['slug' => $podcast->slug]) }}" >
                            <img src="{{ asset('images/btnPlay.svg') }}" alt="" class="absolute top-0 left-0 right-0 bottom-0 m-auto cursor-pointer" />
                        </a>
                    </div>
                </section>



            </section>


            <section class="grid md:grid-cols-2 gap-5">
                @foreach (\App\Repositories\PodcastRepository::getMostViewedPodcasts()->take(4) as $item)
                <a href="{{ route('podcast.show', ['slug' => $item->slug]) }}"
                    class="relative h-[250px] overflow-hidden rounded-2xl bg-no-repeat bg-cover group "
                    style="background-image: url('{{ file_path($item->thumbnail) }}');">
                    <button class="absolute top-0 bottom-0 m-auto left-0 right-0 w-[50px] h-[50px]">
                        <img src="{{ asset('svg/btn-play.svg') }}" alt="" class="animate-pulse" />
                    </button>

                    <div
                        class="p-5 text-white absolute -bottom-[200px] group-hover:bottom-0 left-0 w-full transition-all bg-gradient-to-t from-[#000] to-[rgba(0,0,0,0.5)] shadow-2xl space-y-3">
                        {{-- <h2 class="font-bold">{{ $item->title }}</h2> --}}

                        <div class="flex items-center justify-between">
                            {{-- <div class="flex items-center space-x-2">
                                <img src="{{ asset('images/user-icon.jpg') }}" alt=""
                                    class="w-[34px] h-[34px] rounded-full object-cover" />
                                <span class="font-light">John Doe</span>
                            </div> --}}
                            <h2 class="font-bold">{{ $item->title }}</h2>

                            <span class="font-light">{{ view_count($item->views_count) }} views</span>
                        </div>
                    </div>

                </a>
                @endforeach
            </section>

        </section>
    </div>
</section>
