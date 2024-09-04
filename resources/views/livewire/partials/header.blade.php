<nav class="bg-[#0d0d0d] text-white">
    <div class="container flex items-center justify-between py-2">
        <div class="flex items-center space-x-10">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[80px] w-auto" />
            </a>

            <form action="{{ route('search') }}" class="hidden xl:flex items-center bg-[#000000] w-100 rounded-2xl  px-5 max-[1750px]:hidden  ">
                <i class="fa-solid fa-magnifying-glass text-lg text-white"></i>
                <input type="text" placeholder="Search titles here..." name="q" class="form-control border-0" />
            </form>
        </div>

        <ul class="hidden xl:flex items-center space-x-5">
{{--            <li>--}}
{{--                <a href="{{ route('home') }}" class="hover:text-danger">Home</a>--}}
{{--            </li>--}}

            <li class="relative group">
                <a href="{{ route('tv-shows.home') }}">Tv Shows</a>
            </li>

            <li>
                <a href="{{ route('live-channel.show') }}" class="hover:text-danger">
                    <span class="text-danger">&bull;</span>
                    Live Channel
                </a>
            </li>

            <li>
                <a href="{{ route('pedicab-streams.home') }}" class="hover:text-danger">Pedicab Streams</a>
            </li>
            <li>
                <a href="{{ route('pricing.home') }}" class="hover:text-danger">Pricing</a>
            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="hover:text-danger">
                    <span>More</span>
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <ul class="absolute py-1 whitespace-nowrap space-y-1 bg-dark rounded-xl min-w-[150px] text-sm z-50 hidden group-hover:block">
                    <li>
                        <a href="{{ route('blog.home') }}" class="px-4 py-2 block hover:text-danger">Our Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('merchandize.home') }}" class="px-4 py-2 block hover:text-danger">Our Products</a>
                    </li>
                    <li>
                        <a href="{{ route('podcast.home') }}" class="px-4 py-2 block hover:text-danger">Podcast</a>
                    </li>
                    <li>
                        <a href="{{ route('celebrity-shoutout.home') }}" class="px-4 py-2 block hover:text-danger">Celebrity shoutout</a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.home') }}" class="px-4 py-2 block hover:text-danger">Our Gallery</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="px-4 py-2 block hover:text-danger">About Us</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="px-4 py-2 block hover:text-danger">Contact Us</a>
                    </li>
                </ul>
            </li>
        </ul>


        <ul class="hidden xl:flex items-center space-x-5">
            <li title="Cart">
                <a href="{{ route('cart.home') }}" class="hover:text-danger text-lg relative">
                    <i class="fas fa-shopping-cart"></i>

                    <span class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block absolute -top-1 -right-1">{{ Cart::instance('product')->count() }}</span>
                </a>
            </li>
            @if(!is_user_logged_in())
            <li>
                <a href="{{ route('login') }}" class="btn btn-xl rounded-2xl border hover:bg-danger hover:border-danger">Sign in</a>
            </li>

            <li>
                <a href="{{ route('register') }}" class="btn btn-xl rounded-2xl btn-danger">Register</a>
            </li>
            @else

            <li title="Notification">
                <a href="#" class="hover:text-danger text-lg">
                    <i class="fa fa-solid fa-bell"></i>
                </a>
            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="hover:text-danger border flex items-center space-x-2 rounded-xl p-3">
                    <i class="las la-user-circle text-xl"></i>
                    <span>{{ user()->username }}</span>
                    <i class="fa fa-solid fa-caret-down"></i>
                </a>

                <ul
                    class="absolute top-[56px] right-[0px] py-3 whitespace-nowrap space-y-1 bg-dark rounded-xl min-w-[180px] text-sm z-50 hidden group-hover:block border border-danger">
                    <li class="bg-danger p-3 text-md">
                        <i class="las la-user-circle text-2xl"></i>
                        <div class="font-bold">{{ user()->first_name }} {{ user()->last_name }}</div>
                        <span>({{ user()->username }})</span>
                    </li>
                    <a href="{{ route('user.dashboard') }}"
                       class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                        <i class="las la-user-circle text-xl"></i>
                        <span>Dashboard</span>
                    </a>
                    <li>
                        <a href="javascript:void(0)"
                            x-on:click="$dispatch('trigger-upload-video-modal')"
                            class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                            <i class="las la-cloud-upload-alt text-xl"></i>
                            <span>Upload</span>
                        </a>
                        <a href="{{ route('user.subscription') }}" class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                            <i class="las la-crown text-xl"></i>
                            <span>Subscription</span>
                        </a>



                        <a href="{{ route('user.profile') }}" class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                            <i class="las la-cog text-xl"></i>
                            <span>My Profile</span>
                        </a>

                        <a href="{{ route('logout') }}"
                            class="px-4 py-1 space-x-3 flex items-center hover:text-danger">
                            <i class="las la-sign-out-alt text-xl"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </li>

            @endIf
        </ul>

       <div class="space-x-4 flex  xl:hidden items-center">
        <a href="javascript:viod(0)" class="md:hidden" x-on:click="$dispatch('trigger-search-modal')">
            <i class="fa-solid fa-magnifying-glass text-lg text-white"></i>
        </a>

        <a href="{{ route('cart.home') }}" class="hover:text-danger text-lg relative">
            <i class="fas fa-shopping-cart"></i>

            <span
                class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block absolute -top-1 -right-1">{{ Cart::instance('product')->count() }}</span>
        </a>
        @if(is_user_logged_in())
        <div class="relative group">
            <a href="javascript:void(0)" class="hover:text-danger flex items-center">
                <i class="las la-user-circle text-2xl"></i>
            </a>

            <ul
                class="absolute top-[35px] right-[0px] py-3 whitespace-nowrap space-y-1 bg-dark rounded-xl min-w-[180px] text-sm z-50 hidden group-hover:block border border-danger">
                <li class="bg-danger p-3 text-md">
                    <i class="las la-user-circle text-2xl"></i>
                    <div class="font-bold">{{ user()->first_name }} {{ user()->last_name }}</div>
                    <span>({{ user()->username }})</span>
                </li>
                <li>
                    <a href="javascript:void(0)" x-on:click="$dispatch('trigger-upload-video-modal')"
                        class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                        <i class="las la-cloud-upload-alt text-xl"></i>
                        <span>Upload</span>
                    </a>
                    <a href="{{ route('user.subscription') }}" class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                        <i class="las la-crown text-xl"></i>
                        <span>Subscription</span>
                    </a>

                    <a href="{{ route('user.dashboard') }}" class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                        <i class="las la-user-circle text-xl"></i>
                        <span>My Profile</span>
                    </a>

                    <a href="{{ route('user.profile') }}" class="px-4 py-1 space-x-3 flex items-center  hover:text-danger">
                        <i class="las la-cog text-xl"></i>
                        <span>Setting</span>
                    </a>

                    <a href="{{ route('logout') }}" class="px-4 py-1 space-x-3 flex items-center hover:text-danger">
                        <i class="las la-sign-out-alt text-xl"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        @endIf

        <button class="text-white inline-block" type="button" x-on:click="$dispatch('toggle-mobile-nav')">
            <i class="las la-bars text-3xl"></i>
        </button>
       </div>

    </div>


    <section x-cloak x-data="{ show : false }" @toggle-mobile-nav.window="show = !show" :class="show ? 'top-0 left-0' : '-left-[5000px]'"
        class="transition-all duration-700 ease-in-out w-screen fixed z-[1000] h-screen overflow-y-auto p-7 bg-dark">
        <section class="space-y-10 min-h-screen overflow-y-auto">
            <header class="flex justify-between items-center">
                <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[70px] w-auto" />

                <button class="text-2xl text-white" x-on:click="show = false; isBtn = false">
                    <i class="las la-times"></i>
                </button>
            </header>

            <ul class="flex-1 space-y-5 text-lg md:text-2xl text-white">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-secondary">Home</a>
                </li>

                <li>
                    <a href="{{ route('tv-shows.home') }}" class="hover:text-secondary">Tv Shows</a>
                </li>

                <li>
                    <a href="{{ route('live-channel.show') }}" class="hover:text-secondary">
                        <span class="text-danger">&bull;</span>
                        Live Channel
                    </a>
                </li>

                <li>
                    <a href="{{ route('pedicab-streams.home') }}" class="hover:text-secondary">Pedicab Streams</a>
                </li>

                <li class="relative group">
                    <a href="javascript:void(0)" class="hover:text-danger flex items-center justify-between">
                        <span>More</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <ul
                        class="py-1 whitespace-nowrap space-y-1 bg-dark rounded-xl  z-50 hidden group-hover:block">
                        <li>
                            <a href="{{ route('blog.home') }}" class="px-4 py-2 block hover:text-danger">Our Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('merchandize.home') }}" class="px-4 py-2 block hover:text-danger">Our Products</a>
                        </li>
                        <li>
                            <a href="{{ route('celebrity-shoutout.home') }}" class="px-4 py-2 block hover:text-danger">Celebritity
                                shoutouts</a>
                        </li>
                        <li>
                            <a href="{{ route('gallery.home') }}" class="px-4 py-2 block hover:text-danger">Our Gallery</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="px-4 py-2 block hover:text-danger">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="px-4 py-2 block hover:text-danger">Contact Us</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <ul class="flex justify-center items-center space-x-5 border-t border-secondary py-7">
                <li>
                    <a href="{{ route('login') }}" class="btn btn-xl rounded-2xl border hover:bg-danger hover:border-danger">
                        Sign in
                    </a>
                </li>

                <li>
                    <a href="{{ route('pricing.home') }}" class="btn btn-xl rounded-2xl btn-danger">Register</a>
                </li>
            </ul>


            <ul class="flex items-center justify-center">
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
</nav>
@livewire("partials.search")
