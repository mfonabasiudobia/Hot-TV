<nav class="bg-[#0F0000] text-white">
    <div class="container flex items-center justify-between py-2">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-[80px] w-auto" />
        </a>

        <form class="flex items-center">
            <i class="las la-search"></i>
            <input type="text" placeholder="Search titles here..." class="form-control bg-transparent border-0" />
        </form>

        <ul class="flex items-center space-x-5">
            <li>
                <a href="{{ route('home') }}">Home</a>
            </li>

            <li>
                <a href="{{ route('tv-shows.home') }}">Tv Shows</a>
            </li>

            <li>
                <a href="#">
                    <span class="text-danger">&bull;</span>
                    Live
                </a>
            </li>

            <li>
                <a href="#">Pedicab Streams</a>
            </li>
        </ul>


        <ul class="flex items-center space-x-5">
            <li>
                <a href="{{ route('login') }}" class="btn btn-xl rounded-2xl border hover:bg-danger hover:border-danger">Sign in</a>
            </li>
        
            <li>
                <a href="{{ route('register') }}" class="btn btn-xl rounded-2xl btn-danger">Register</a>
            </li>
        </ul>

    </div>
</nav>