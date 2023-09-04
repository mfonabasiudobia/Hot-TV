<div class="py-5 bg-black text-white space-y-7 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => $page->name, 'route' => null]
            ]" />
    <div class="container space-y-7 pb-10">


        <section class="space-y-7">
            <h1 class="font-semibold text-xl md:text-3xl">{{ $page->name }}</h1>


            <section class="space-y-5">
                {!! $page->content !!}
            </section>

        </section>
    </div>


    @livewire("home.partials.newsletter")
</div>