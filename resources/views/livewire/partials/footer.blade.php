<footer class="w-full">
    <section class="bg-[#0F0000] text-light w-full py-10">
        <div class="container grid md:grid-cols-5 2xl:grid-cols-7 gap-10 py-5">
            <section class="md:col-span-2 space-y-5">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-white.png') }}" />
                </a>

                <p>HOT TV STATION, also known as HTS, was founded by Houston, Texas entrepreneur, and world renown humanitarian Malik Rasheed. The station provides live streaming services for everyone. We specialize in bringing attention to all talented people. Let us help you take your business and platform to the next level.</p>

                <section class="py-3 space-y-3">
                    <h2 class="text-xl">Follow Us</h2>

                    <ul class="flex items-center">
                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-facebook-f"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                               <i class="lab la-youtube"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-twitter"></i>
                            </a>
                        </li>


                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                               <i class="lab la-linkedin"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </section>
            </section>

            <section class="space-y-3">
                <h2 class="font-medium text-xl">Quick Links</h2>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('about') }}">About us</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li>
                        <a href="{{ route('merchandize.home') }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('faqs') }}">FAQ</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Sign Up</a>
                    </li>
                </ul>
            </section>


            <section class="space-y-3 md:col-span-2">
                <h2 class="font-medium text-xl">Tv Show Categories</h2>
                <section>
                    <ul class="grid grid-cols-2 gap-3">
                        @foreach (\App\Models\ShowCategory::get() as $item)
                                <li>
                                    <a href="{{ route('search', ['q' => $item->name ]) }}">{{ $item->name }}</a>
                                </li>
                        @endforeach


                    </ul>
                </section>
            </section>

            <section class="md:col-span-2">
                <div class="space-y-3 p-5 rounded-lg bg-gradient-to-r from-[#FF055F] to-[#630047]">
                    <h2>Watch HTS Everywhere & Anytime Now</h2>
                    <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>

                    <div>
                        <a href="#" class="btn btn-xl bg-white font-bold text-dark whitespace-nowrap">
                            Get Premium Access
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </section>
    <section class="bg-danger text-sm py-5 text-white text-sm md:text-base">
        <div class="container flex text-center md:text-left flex-col md:flex-row justify-between items-center">
            <ul>
                <li>
                    HTS VIDEO STREAMING - © 2023 All Rights Reserved
                </li>
            </ul>
        </div>
    </section>
</footer>
