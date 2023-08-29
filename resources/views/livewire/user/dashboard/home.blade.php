<section class="bg-black text-white">
    @livewire("user.partials.nav")

    @if($currentNav === 'favourites')
        @livewire("user.favourites.home")
    @elseif($currentNav === 'videos')
        @livewire("user.videos.home")
    @elseif($currentNav === 'watchlist')
        @livewire("user.watchlist.home")
    @elseif($currentNav === 'playlist')
        @livewire("user.playlist.home")
    @endIf
</section>