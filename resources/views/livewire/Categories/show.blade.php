<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => 'Categories', 'route' => null]
            ]" />
    <div class="container space-y-7">

        <section class="space-y-16">

        @if(isset($category->posts[0]))
            @php($post = $category->posts[0])
            <a class="min-h-[50vh] rounded-2xl relative bg-center block"
                href="{{ route('blog.show', ['slug' => $post->slug]) }}"
                style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('{{ asset('storage') . '/' . $post->image }}');">
                <div class="md:w-3/4 absolute bottom-0 left-0 p-5 space-y-3">
                    @if($category)
                        <span class="text-danger text-xs">{{ $category->name }}</span>
                    @endIf
                    <h1 class="font-semibold text-xl md:text-3xl">{{ Str::limit($post->name, 80) }}</h1>

                    <span class="inline-block text-sm">{{ $post->createdAt() }}</span>
                </div>
            </a>
        @endIf

            <section class="space-y-10">
                <header class="flex justify-center">
                    <h1 class="font-semibold text-xl md:text-3xl">Latest Post</h1>
                </header>


                <section class="grid md:grid-cols-3 gap-5">
                    @forelse ($category->posts as $post)
                    <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="block p-3 border border-secondary rounded-2xl">
                        <img src="{{ asset('storage') }}/{{ $post->image }}" alt="" class="w-full h-[250px] rounded-xl" />

                        <section class="space-y-2 p-2">
                            @if($post->firstCategory)
                                <span class="text-danger text-xs">{{ $post->firstCategory->name }}</span>
                            @endIf

                            <h2 class="font-semibold block">{{ Str::limit($post->name, 80) }}</h2>

                            <span class="text-secondary text-sm inline-block">{{ $post->createdAt() }}</span>
                        </section>
                    </a>
                    @empty
                        <p> No Data </p>
                    @endforelse
                </section>





            </section>

        </section>



    </div>
    @livewire("home.partials.newsletter")
</div>
