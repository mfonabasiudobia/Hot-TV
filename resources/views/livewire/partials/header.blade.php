@livewire("user.videos.modal.upload-video")
<style>
        @property --border-angle {
            inherits: false;
            initial-value: 0deg;
            syntax: '<angle>';
        }
    </style>
<nav class="bg-[#0d0d0d] text-white">
    <div class="container flex items-center justify-between py-2">
        <div class="flex items-center space-x-10">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[50px] w-auto" />
            </a>

            <ul class="hidden xl:flex items-center space-x-5">
                <li class="relative group">
                    <a href="javascript:void(0)" class="hover:text-danger" id="browse">
                        <span>Browse</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <ul class="absolute top-[56px] py-1 whitespace-nowrap space-y-1 bg-dark min-w-[150px] text-sm z-50 hidden" id="browseMenu">
                        <div class="flex p-4">
                            <div class="border-r-2 border-white" style="border-right: 2px solid white;">
                                <li class="relative group">
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('tv-shows.home') }}">Tv Shows</a>
                                </li>

                                <li>
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('live-channel.show') }}">
                                        <span class="text-danger">&bull;</span>
                                        Live Channel
                                    </a>
                                </li>

                                <li>
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('pedicab-streams.home') }}">Pedicab Streams</a>
                                </li>
                                <li>
                                    <a href="{{ route('podcast.home') }}" class="px-4 py-4 block hover:text-danger">Podcast</a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery.home') }}" class="px-4 py-4 block hover:text-danger">Gallery</a>
                                </li>
                                <li>
                                    <a href="{{ route('celebrity-shoutout.home') }}" class="px-4 py-2 block hover:text-danger">Celebritity
                                        shoutouts</a>
                                </li>
                            </div>
                            <div class="flex flex-wrap" style="width: 700px">
                                @foreach (\App\Models\ShowCategory::limit(15)->get() as $category)
                                    <div class="px-4 py-2 rounded-md" style="width: 33%;">
                                        <li>
                                            <a class="block hover:text-danger" href="{{ route('search', ['q' => $category->name ]) }}">
                                                {{ \Illuminate\Support\Str::limit($category->name, 15) }}
                                            </a>
                                        </li>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </ul>
                </li>

                <li class="relative group tile-group">
                    <a href="javascript:void(0)" class="hover:text-danger" id="socialMedia">
                        <span>Social Media</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <ul id="socialMediaMenu" class="absolute top-[45px] min-w-[250px] p-4 whitespace-nowrap grid grid-cols-2 gap-4 bg-dark text-sm z-50 hidden">
                        <div style="width: 400px;">
                            <li class="tile">
                                <a class="px-4 py-4 block hover:bg-secondary hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-facebook"></i></div>
                                    <div class="text-left">Facbook</div>
                                </a>
                            </li>
                            <li class="tile">
                                <a class="px-4 py-4 block hover:bg-secondary hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-linkedin"></i></div>
                                    <div class="text-left">LinkedIn</div>
                                </a>
                            </li>
                            <li class="tile">
                                <a class="px-4 py-4 block hover:bg-secondary hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-twitter"></i></div>
                                    <div class="text-left">Twitter</div>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>



                <li class="relative group">
                    <a href="#" class="hover:text-danger">
                        <span>News & Blog</span>
                    </a>
                </li>
            </ul>
        </div>

        <form action="{{ route('search') }}" class="hidden xl:flex items-center bg-[#000000] w-100 rounded-2xl  px-5 max-[1750px]:hidden  ">
            <i class="fa-solid fa-magnifying-glass text-lg text-white"></i>
            <input type="text" placeholder="Search titles here..." name="q" class="form-control border-0" />
        </form>

        <ul class="hidden xl:flex items-center space-x-5">
            <!-- <li title="Cart">
                <a href="{{ route('cart.home') }}" class="hover:text-danger text-lg relative">
                    <i class="fas fa-shopping-cart"></i>

                    <span class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block absolute -top-1 -right-1">{{ Cart::instance('product')->count() }}</span>
                </a>
            </li> -->
            @if(!is_user_logged_in())
            <li>
            <a href="{{ route('pricing.home') }}" class="py-3.5 px-8 w-full max-w-[422px] animate-border rounded-xl border border-transparent [background:linear-gradient(45deg,#172033,theme(colors.slate.800)_50%,#172033)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.600/.48)_80%,_theme(colors.indigo.500)_86%,_theme(colors.indigo.300)_90%,_theme(colors.indigo.500)_94%,_theme(colors.slate.600/.48))_border-box]">
                <span >Subscribe Now</span>
            </a>


            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="hover:text-danger" id="authDropDown">
                    <i class="fa-regular fa-user"></i>
                </a>

                <ul style="width: 350px; right: -55px;" class="absolute top-[56px] py-1 whitespace-nowrap space-y-1 bg-dark min-w-[150px] text-sm z-50 hidden" id="authDropDownMenu">
                    <li>
                        <a href="{{ route('register') }}" class="btn btn-xl py-4 text-left">
                            Create Account
                            <div>
                                <small> Join for free or go premuim </small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="btn btn-xl py-4 text-left">
                            Login
                            <div> <small> Already joined hottv? Welcome Back </small> </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}" class="btn btn-xl py-4 text-center" style="width: 100%; background: red">
                            <i class="fa-solid fa-crown"></i>
                            7 Day Free Trial
                        </a>
                    </li>

                </ul>
            </li>



            @else

            <!-- <li title="Notification">
                <a href="#" class="hover:text-danger text-lg">
                    <i class="fa fa-solid fa-bell"></i>
                </a>
            </li> -->
            @livewire('subscription-status')
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
                <i class="fas la-user-circle text-2xl"></i>
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
                <li class="relative group tile-group">
                    <a href="javascript:void(0)" class="hover:text-danger flex items-center justify-between" id="browse">
                        <span>Browse</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <ul class="class="py-1 whitespace-nowrap space-y-1 bg-dark rounded-xl  z-50 hidden group-hover:block" id="browseMenu">
                        <div class="flex p-4">
                            <div class="border-r-2 border-white" style="border-right: 2px solid white;">
                                <li class="relative group">
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('tv-shows.home') }}">Tv Shows</a>
                                </li>

                                <li>
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('live-channel.show') }}">
                                        <span class="text-danger">&bull;</span>
                                        Live Channel
                                    </a>
                                </li>

                                <li>
                                    <a class="px-4 py-4 block hover:text-danger" href="{{ route('pedicab-streams.home') }}">Pedicab Streams</a>
                                </li>
                                <li>
                                    <a href="{{ route('podcast.home') }}" class="px-4 py-4 block hover:text-danger">Podcast</a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery.home') }}" class="px-4 py-4 block hover:text-danger">Gallery</a>
                                </li>
                            </div>

                        </div>
                    </ul>
                </li>
                <li class="relative group tile-group">
                    <a href="javascript:void(0)" class="hover:text-danger flex align-center justify-between" id="socialMedia">
                        <span>Social Media</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    <ul id="socialMediaMenu" class="absolute top-[56px] min-w-[250px] p-4 whitespace-nowrap grid grid-cols-2 gap-4 bg-dark text-sm z-50 hidden group-hover:block">
                        <div style="width: 400px;">
                            <li class="tile">
                                <a class="px-4 py-4 hover:bg-color-gray-400 hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-facebook"></i></div>
                                    <div class="text-left">Facbook</div>
                                </a>
                            </li>
                            <li class="tile">
                                <a class="px-4 py-4 hover:bg-color-gray-400 hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-linkedin"></i></div>
                                    <div class="text-left">LinkedIn</div>
                                </a>
                            </li>
                            <li class="tile">
                                <a class="px-4 py-4 hover:bg-color-gray-400 hover:text-danger flex" href="{{ route('tv-shows.home') }}">
                                    <div class="mr-2"><i class="fa-brands fa-twitter"></i></div>
                                    <div class="text-left">Twitter</div>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>


                <li class="relative group">
                    <a href="#" class="hover:text-danger">
                        <span>News & Blog</span>
                    </a>
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
        </section>
    </section>
</nav>
@livewire("partials.search")
@push('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const browse = document.querySelector("#browse");
    const browseMenu = document.querySelector("#browseMenu");

    const socialMedia = document.querySelector("#socialMedia");
    const socialMediaMenu = document.querySelector("#socialMediaMenu");

    const authDropDown = document.querySelector("#authDropDown");
    const authDropDownMenu = document.querySelector("#authDropDownMenu");

    browse.addEventListener("click", function () {
        browseMenu.style.display = 'block';
    });

    // Optional: Close the dropdown if clicked outside
    document.addEventListener("click", function (event) {
        if (!browse.contains(event.target) && !browse.contains(event.target)) {
            browseMenu.style.display = 'none';
        }
    });

    socialMedia.addEventListener("click", function () {
        socialMediaMenu.style.display = 'block';
    });

    // Optional: Close the dropdown if clicked outside
    document.addEventListener("click", function (event) {
        if (!socialMedia.contains(event.target) && !socialMediaMenu.contains(event.target)) {
            socialMediaMenu.style.display = 'none';
        }
    });

    authDropDown.addEventListener("click", function () {
        authDropDownMenu.style.display = 'block';
    });

    // Optional: Close the dropdown if clicked outside
    document.addEventListener("click", function (event) {
        if (!authDropDown.contains(event.target) && !authDropDownMenu.contains(event.target)) {
            authDropDownMenu.style.display = 'none';
        }
    });
});
</script>
@endpush
