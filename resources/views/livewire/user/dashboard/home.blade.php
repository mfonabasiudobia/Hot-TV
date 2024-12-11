<section class="bg-black text-white">
    @livewire("user.partials.nav")

{{--    @if($currentNav === 'favourites')--}}
{{--        @livewire("user.favourites.home")--}}
    @if($currentNav === 'videos')
        @livewire("user.videos.home")
    @elseif($currentNav === 'watchlist')
        @livewire("user.watchlist.home")
    @elseif($currentNav === 'wishlist')
    {{--    @livewire("user.wishlist.home")--}}
    @elseif($currentNav === 'screenshots')
        @livewire("user.screenshots.home")
    @elseif($currentNav === 'watch-history')
        @livewire("user.watch-history.home")
    @endIf
</section>

@push('script')
<script>
    Livewire.on('setNav', function () {
            var swiper = new Swiper(".slider", {
                effect: "coverflow",
                grabCursor: true,
                pagination: {
                    el: ".swiper-pagination",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
            });
    });
    document.addEventListener('change-nav', (event) => {
        setTimeout(() => {
            window.history.replaceState(null, null, `?p=${event.detail.page}`);
        }, 5000);
    })
</script>
@endPush
