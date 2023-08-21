<div class="py-5 bg-black text-white space-y-7">
    <div class="container space-y-7">
        <x-atoms.breadcrumb :routes="[
            ['title' => 'Blog', 'route' => route('blog.home')],
            ['title' => 'The Impact of Technology on the Workplace: How Technology is Changing', 'route' => null]
        ]" />


        <section class="space-y-10">

            <div class="space-y-3 md:w-3/4">
                <span class="btn btn-xs bg-danger">Technology</span>
                <h1 class="font-semibold text-xl md:text-3xl">The Impact of Technology on the Workplace: How
                    Technology is Changing</h1>
            
                <span class="inline-block text-sm">August 20, 2022</span>
            </div>


            <section class="space-y-7">
                <img src="{{ asset('images/blog/single-blog-post.png') }}" alt="" />


                <p>Traveling is an enriching experience that opens up new horizons, exposes us to different cultures, and creates memories
                that last a lifetime. However, traveling can also be stressful and overwhelming, especially if you don't plan and
                prepare adequately. In this blog article, we'll explore tips and tricks for a memorable journey and how to make the most
                of your travels.</p>
                
                <p>One of the most rewarding aspects of traveling is immersing yourself in the local culture and customs. This includes
                trying local cuisine, attending cultural events and festivals, and interacting with locals. Learning a few phrases in
                the local language can also go a long way in making connections and showing respect.</p>


                <p>Before embarking on your journey, take the time to research your destination. This includes understanding the local
                culture, customs, and laws, as well as identifying top attractions, restaurants, and accommodations. Doing so will help
                you navigate your destination with confidence and avoid any cultural faux pas.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. In hendrerit gravida rutrum quisque non tellus orci ac auctor. Mi ipsum faucibus vitae aliquet nec ullamcorper
                sit amet. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae. Viverra adipiscing at in tellus.4</p>

            </section>


        </section>



    </div>
    @livewire("home.partials.newsletter")
</div>