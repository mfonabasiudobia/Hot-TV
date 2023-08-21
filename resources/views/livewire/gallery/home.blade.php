<div class="py-5 bg-black text-white">
    <div class="container space-y-7">
        <x-atoms.breadcrumb :routes="[['title' => 'Our Gallery', 'route' => null ]]" />

        <section class="space-y-7">
            <header class="space-y-3">
                <h2 class="font-semibold text-xl md:text-3xl">Our Gallery</h2>
                <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o
                    web, precisamos
                    desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que
                    vamos encontrar
                    como desenvolvedores e desenvolvedoras web.</p>
            </header>


            <section class="grid md:grid-cols-3 gap-7">
                <section class="md:col-span-2 min-h-[50vh] rounded-2xl relative">
                    <img src="{{ asset('images/pedicab-image1.png') }}" alt="" class="h-[50vh] w-full" />
                </section>

                <section>
                    <img src="{{ asset('images/pedicab-stream2.png') }}" alt="" class="h-[50vh] w-full" />
                </section>
            </section>


            <section class="grid md:grid-cols-3 gap-7">
                <section class="order-2 md:order-1">
                    <img src="{{ asset('images/pedicab-stream2.png') }}" alt="" class="h-[50vh] w-full" />
                </section>

                <section class="md:col-span-2 min-h-[50vh] rounded-2xl relative order-1 md:order-2">
                   <img src="{{ asset('images/pedicab-image1.png') }}" alt="" class="h-[50vh] w-full" />
                </section>
            </section>

        </section>


        <section class="grid grid-cols-2 md:grid-cols-3 gap-7">
            @foreach (range(1, 6) as $item)
            <a href="#">
                <img src="{{ asset('images/placeholder-05.png') }}" alt="" />
            </a>
            @endforeach
        </section>


        <div class="flex justify-center md:justify-end text-sm">
            <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-7">
                <span class="opacity-60">Showing 10 from 10 data</span>

                <div class="space-x-1 flex items-center">
                    <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                        <i class="las la-angle-double-left"></i>
                        <span>Previous</span>
                    </a>

                    <a href="#" class="space-x-1 btn btn-sm bg-danger rounded-xl">
                        1
                    </a>

                    <a href="#" class="space-x-1 btn btn-sm bg-dark rounded-xl flex items-center">
                        <span>Next</span>
                        <i class="las la-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>
        </section>
    </div>
</div>