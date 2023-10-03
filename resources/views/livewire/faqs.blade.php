<div class="py-5 bg-black text-white space-y-7 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => $faq->name, 'route' => null]
            ]" />
    <div class="container space-y-7">

        <section class="space-y-7">

            {!! do_shortcode($faq->content) !!}

        </section>
    </div>


    @livewire("home.partials.newsletter")
</div>