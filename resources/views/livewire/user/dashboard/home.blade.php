<section class="bg-black text-white">
    @livewire("user.partials.nav")

    @if($currentNav === 'favourites')
        @livewire("user.favourites.home")
    @elseif($currentNav === 'videos')
        @livewire("user.videos.home")
    @elseif($currentNav === 'watchlist')
        @livewire("user.watchlist.home")
    @elseif($currentNav === 'wishlist')
        @livewire("user.wishlist.home")
    @elseif($currentNav === 'screenshots')
        @livewire("user.screenshots.home")
    @elseif($currentNav === 'watch-history')
        @livewire("user.watch-history.home")
    @endIf
</section>