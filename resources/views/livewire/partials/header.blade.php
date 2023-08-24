<nav class="bg-[#0d0d0d] text-white">
    <div class="container flex items-center justify-between py-2">
        <div class="flex items-center space-x-10">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[80px] w-auto" />
            </a>
            
            <form class="hidden md:flex items-center">
                <i class="las la-search"></i>
                <input type="text" placeholder="Search titles here..." class="bg-black form-control border-0" />
            </form>
        </div>

        <ul class="hidden lg:flex items-center space-x-5">
            <li>
                <a href="{{ route('home') }}" class="hover:text-danger">Home</a>
            </li>

            <li>
                <a href="{{ route('tv-shows.home') }}" class="hover:text-danger">Tv Shows</a>
            </li>

            <li>
                <a href="{{ route('live-channel.show') }}" class="hover:text-danger">
                    <span class="text-danger">&bull;</span>
                    Live
                </a>
            </li>

            <li>
                <a href="{{ route('pedicab-streams.home') }}" class="hover:text-danger">Pedicab Streams</a>
            </li>
        </ul>


        <ul class="hidden lg:flex items-center space-x-5 ">
            <li>
                <a href="{{ route('login') }}" class="btn btn-xl rounded-2xl border hover:bg-danger hover:border-danger">Sign in</a>
            </li>
        
            <li>
                <a href="{{ route('register') }}" class="btn btn-xl rounded-2xl btn-danger">Register</a>
            </li>
        </ul>


        <button class="text-white inline-block lg:hidden" type="button"
            x-on:click="$dispatch('toggle-mobile-nav')">
            <i class="las la-bars text-3xl"></i>
        </button>

    </div>


    <section x-cloak x-data="{ show : false }" @toggle-mobile-nav.window="show = !show" :class="show ? 'top-0' : '-top-[5000px]'"
        class="transition-all duration-700 ease-in-out w-screen fixed z-[1000] h-screen p-7 bg-dark">
        <section class="space-y-10 min-h-screen overflow-y-auto">
            <header class="flex justify-between items-center">
                <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[70px] w-auto" />
            
                <button class="text-xl text-white" x-on:click="show = false; isBtn = false">
                    Close <i class="las la-times"></i>
                </button>
            </header>
            
            <ul class="flex-1 space-y-5 text-lg md:text-2xl font-bold text-white text-center">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-secondary">Home</a>
                </li>
            
                <li>
                    <a href="{{ route('tv-shows.home') }}" class="hover:text-secondary">Tv Shows</a>
                </li>
            
                <li>
                    <a href="{{ route('live-channel.show') }}" class="hover:text-secondary">
                        <span class="text-danger">&bull;</span>
                        Live
                    </a>
                </li>
            
                <li>
                    <a href="{{ route('pedicab-streams.home') }}" class="hover:text-secondary">Pedicab Streams</a>
                </li>
            
            </ul>
            
            <ul class="flex justify-center items-center space-x-5 border-t border-secondary py-7">
                <li>
                    <a href="{{ route('login') }}" class="btn btn-xl rounded-2xl border hover:bg-danger hover:border-danger">
                        Sign in
                    </a>
                </li>
            
                <li>
                    <a href="{{ route('register') }}" class="btn btn-xl rounded-2xl btn-danger">Register</a>
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