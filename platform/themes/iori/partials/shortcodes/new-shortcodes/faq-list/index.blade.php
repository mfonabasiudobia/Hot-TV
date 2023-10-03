<section class="space-y-5 text-secondary">
    @foreach (\Botble\Faq\Models\Faq::get()->take($shortcode->number_of_faqs) as $faq)
    <div class="space-y-3 border border-secondary p-3" x-data="{ show : false}" x-on:click.away="show = false">
        <header class="flex items-center space-x-3 justify-between cursor-pointer" x-on:click="show = !show">
            <h2 class="text-danger">{{ $faq->question }}</h2>
            <button class="min-w-[45px] min-h-[45px] text-danger">
                <i class="las la-angle-down"></i>
            </button>
        </header>
        <div x-show="show">
            {!! $faq->answer !!}
        </div>
    </div>
    @endforeach
</section>