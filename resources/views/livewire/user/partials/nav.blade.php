<section class="bg-dark p-5 text-white space-y-10 min-h-[35vh] flex flex-col justify-end">
    <section
        class="space-y-5 md:space-y-0 flex md:items-center flex-col md:flex-row justify-start items-start md:justify-between md:w-1/2">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/user-icon.jpg') }}" alt="" class="w-[70px] h-[70px] rounded-full" />
            <h5 class="text-xl font-semibold">
                {{ user()->first_name }} {{ user()->last_name }} <br />

                ({{ user()->username }})
            </h5>
        </div>

        <button class="btn btn-sm md:btn-md rounded-xl btn-danger space-x-2 flex items-center">
            <span>Upgrade Premium</span>

            <span class="bg-yellow-500 h-[25px] w-[25px] inline-block rounded-full flex items-center justify-center">
                <i class="las la-crown"></i>
            </span>
        </button>
    </section>

    <section class="flex items-start md:items-center flex-col space-y-7 md:space-y-0 md:flex-row md:space-x-3 md:justify-between">
        <ul class="flex items-center space-x-5 md:space-x-7 text-sm md:text-base">
            <li>
                <a href="#" wire:click.prevent="setNav('favourites')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'favourites' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Favourites
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('playlist')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'playlist' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Playlist
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('watchlist')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'watchlist' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Watchlist
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('videos')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'videos' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Videos
                </a>
            </li>
        </ul>

    @if($currentNav === 'videos')
        <button class="btn btn-danger btn-sm inline-block font-semibold">
            <i class="las la-upload"></i>
            <span>Upload Video</span>
        </button>
    @elseif($currentNav === 'watchlist')
        <button class="btn btn-danger btn-sm inline-block font-semibold">
            <i class="las la-edit"></i>
            <span>Edit</span>
        </button>
    @elseif($currentNav === 'playlist')
        <button class="btn btn-danger btn-sm inline-block font-semibold">
           Create Playlist
        </button>
    @endIf
    </section>
</section>