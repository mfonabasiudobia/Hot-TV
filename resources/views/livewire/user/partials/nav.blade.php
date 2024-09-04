
<section class="bg-dark p-5 text-white space-y-10 min-h-[35vh] flex flex-col justify-end">
    @livewire("user.partials.modal.upload-pic")

    <section
        class="space-y-5 md:space-y-0 flex md:items-center flex-col md:flex-row justify-start items-start md:justify-between md:w-1/2">
        <div class="flex items-center space-x-4">

{{--            <img src="{{ //asset('images/user-icon.jpg') }}" alt="" class="w-[70px] h-[70px] rounded-full"   />--}}


            <img src="{{ $avatar  }}" alt="" class="w-[70px] h-[70px] rounded-full" x-on:click="$dispatch('trigger-change-avatar-modal')"/>
            <h5 class="text-xl font-semibold">
                {{ user()->first_name }} {{ user()->last_name }} <br />
                ({{ user()->username }})
            </h5>
        </div>

        <button class="btn btn-sm md:btn-md rounded-xl btn-danger space-x-2 flex items-center">

            <span>{{ $subscriptionPlan }} user</span>

            <span class="bg-yellow-500 h-[25px] w-[25px] rounded-full flex items-center justify-center">
                <i class="las la-crown"></i>
            </span>
        </button>
    </section>

    <section class="flex items-start md:items-center flex-col space-y-7 md:space-y-0 md:flex-row md:space-x-3 md:justify-between">
        <ul class="flex items-center space-x-5 md:space-x-7 text-sm md:text-base overflow-x-auto overflow-y-hidden w-full">
            <li>
                <a href="#" wire:click.prevent="setNav('favourites')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'favourites' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Favourites
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('wishlist')"
                    class="flex items-center relative space-x-1 py-3 transition-all hover:text-danger {{ $currentNav === 'wishlist' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    <span>Wishlist</span>

                    <span
                        class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block">
                        {{ \Botble\Ecommerce\Models\Wishlist::where('customer_id', auth()->id())->count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('watchlist')"
                    class="flex items-center relative space-x-1 py-3 transition-all hover:text-danger {{ $currentNav === 'watchlist' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    <span>Watchlist</span>

                    <span class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block">
                        {{ \App\Models\Watchlist::where('user_id', auth()->id())->count() }}
                    </span>
                </a>
            </li>
            {{-- <li>
                <a href="#" wire:click.prevent="setNav('videos')"
                    class="py-3 transition-all hover:text-danger {{ $currentNav === 'videos' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    Videos
                </a>
            </li> --}}
            <li>
                <a href="#" wire:click.prevent="setNav('screenshots')"
                    class="relative py-3 space-x-1 transition-all hover:text-danger {{ $currentNav === 'screenshots' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    <span>Screenshots</span>

                    <span class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block">
                        {{ Botble\Gallery\Models\Gallery::where('user_id', auth()->id())->count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setNav('watch-history')"
                    class="flex items-center whitespace-nowrap relative py-3 space-x-1 transition-all hover:text-danger {{ $currentNav === 'watch-history' ? 'border-b-2 border-danger font-semibold' : '' }}">
                    <span>Watch History</span>

                    <span class="min-w-[15px] min-h-[15px] text-xs text-center rounded-full text-white bg-danger inline-block">
                        {{ \App\Models\TvShowView::where('user_id', auth()->user()->id)->groupBy('tv_show_id')->selectRaw('tv_show_views.tv_show_id')->count() }}
                    </span>
                </a>
            </li>
        </ul>

        @if($currentNav === 'watchlist')
        <button class="btn btn-danger btn-sm inline-block font-semibold">
            <i class="las la-edit"></i>
            <span>Edit</span>
        </button>
        @elseif($currentNav === 'screenshots')
        <button class="btn btn-danger btn-sm inline-block font-semibold" x-on:click="$dispatch('trigger-upload-screenshot-modal')">
            <i class="las la-camera"></i>
            <span>Screenshots</span>
        </button>
        @else
        <button class="btn btn-danger btn-sm inline-block font-semibold" x-on:click="$dispatch('trigger-upload-video-modal')">
            <i class="las la-upload"></i>
            <span>Upload Video</span>
        </button>
        @endIf
    </section>
</section>

