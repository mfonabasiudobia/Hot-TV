<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => 'Blog', 'route' => route('blog.home')],
                ['title' => $post->name, 'route' => null]
            ]" />
    <div class="container space-y-7">
        <section class="space-y-10">

            <div class="space-y-3 md:w-3/4">
                
                @if (!$post->categories->isEmpty())
                <span>
                    {{-- <a href="{{ $post->categories->first()->url }}">{{ $post->categories->first()->name }}</a> --}}

                    <span class="btn btn-xs bg-danger">{{ $post->categories->first()->name }}</span>
                </span>
                @endif

                <h1 class="font-semibold text-xl md:text-3xl">{{ $post->name }}</h1>
            
                <span class="inline-block text-sm">{{ $post->createdAt() }}</span>
            </div>


            <section class="space-y-7">
                {{-- <img src="{{ asset('storage') }}/{{ $post->image }}" alt="" /> --}}


                {{-- {!! $post->content !!} --}}

                {!! BaseHelper::clean($post->content) !!}

            </section>


        </section>



    </div>
    @livewire("home.partials.newsletter")
</div>