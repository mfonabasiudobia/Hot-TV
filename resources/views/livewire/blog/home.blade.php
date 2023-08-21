<div class="py-5 bg-black text-white space-y-7">
    <div class="container space-y-7">
        <x-atoms.breadcrumb :routes="[
            ['title' => 'Blog', 'route' => null]
        ]" />


        <section class="space-y-16">

            <section class="min-h-[50vh] rounded-2xl relative"
                style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('{{ asset('images/blog/blog-overlay.png') }}');">


                <div class="md:w-3/4 absolute bottom-0 left-0 p-5 space-y-3">
                    <span class="btn btn-xs bg-danger">Technology</span>
                    <h1 class="font-semibold text-xl md:text-3xl">The Impact of Technology on the Workplace: How Technology is Changing</h1>

                    <span class="inline-block text-sm">August 20, 2022</span>
                </div>
            
            </section>
            
            <section class="space-y-10">
                <header class="flex justify-center">
                    <h1 class="font-semibold text-xl md:text-3xl">Latest Post</h1>
                </header>
            
            
                <section class="grid md:grid-cols-3 gap-5">
                    @foreach (range(1, 9) as $item)
                    <div class="p-3 border border-secondary rounded-2xl">
                        <img src="{{ asset('images/blog/blog-1.png') }}" alt="" class="w-full" />
            
                        <section class="space-y-2 p-2">
                            <span class="text-danger text-xs">Technology</span>
            
                            <h3 class="font-semibold">The Impact of Technology on the Workplace: How Technology is Changing</h3>
            
                            <span class="text-secondary text-sm inline-block">August 20, 2022</span>
                        </section>
                    </div>
                    @endforeach
                </section>
            
                <footer class="flex justify-center">
                    <a href="#" class="btn btn-md border border-secondary opacity-75">View All Post</a>
                </footer>
            
            </section>

        </section>
            


    </div>
    @livewire("home.partials.newsletter")
</div>