<div class="py-5 bg-black text-white space-y-7 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => $faq->name, 'route' => null]
            ]" />
    <div class="container space-y-7">
        <section class="space-y-7">
            <header class="md:w-3/4 text-center mx-auto space-y-3">
                <span class="barlow-font text-xl md:text-3xl">{!! $faq->description !!}</span>
                <h1 class="font-semibold text-xl md:text-3xl">{{ $faq->name }}</h1>
                <p class="text-[#7E7E7E]">{!! $faq->content !!}</p>
            </header>


            <section class="space-y-5 text-secondary">
                @foreach ($faqs as $faq)
                    <div class="space-y-3 border border-secondary p-3" x-data="{ show : true}" x-on:click.away="show = false">
                        <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
                            <h2 class="text-danger">{{ $faq->question }}</h2>
                            <button class="min-w-[45px] min-h-[45px] text-danger">
                                <i class="las la-angle-down"></i>
                            </button>
                        </header>
                        <p x-show="show">
                            {!! $faq->answer !!}
                        </p>
                    </div>
                @endforeach
            
            </section>

        </section>
    </div>


    @livewire("home.partials.newsletter")
</div>