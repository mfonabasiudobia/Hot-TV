<main class="min-h-screen text-white">
  <section style="background-image: url('{{ asset('images/background-image-01.png') }}">
    <section class="py-16">
      <div class="container grid md:grid-cols-2 gap-10">
        <section class="space-y-7 md:order-1 order-2">
          <div class="hidden md:flex items-center space-x-5">
            <button class="text-danger">
              Live Channel
            </button>
    
            <button class="hover:text-danger">
              Pedicab Streams
            </button>
    
            <button class="hover:text-danger">Tv Shows</button>
          </div>
          <h1 class="font-extrabold text-3xl md:text-5xl">HTS Live Channel</h1>
          <div class="space-y-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna
              aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
    
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna
              aliqua.</p>
          </div>
    
          <div class="flex items-center space-x-5">
            <a 
              href="{{ route('live-channel.show') }}"
              class="btn btn-danger btn-lg rounded-xl py-3 flex justify-between items-center space-x-5">
              <span>Watch Now</span>
    
              <i class="las la-play"></i>
            </a>
    
            <button class="btn border btn-lg rounded-xl py-3 hover:bg-danger hover:border-danger">
              Add to Watchlist
            </button>
          </div>
        </section>
    
        <section class="order-1 md:order-2 relative">
          <img src="{{ asset('images/coverFilm.png') }}" alt="" />

          <a href="{{ route('live-channel.show') }}">
            <img src="{{ asset('svg/btn-play-white.svg') }}" alt=""
              class="absolute inset-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" />
          </a>
        </section>
      </div>
    </section>
    
    @livewire("home.partials.recently-watch")
  </section>

  @livewire("home.partials.pedicab-streams")

  @livewire("home.partials.recommendation")

  @livewire("home.partials.most-viewed")

  @livewire("home.partials.popular-podcast")

  @livewire("home.partials.pricing")

  @livewire("home.partials.partners")

  
  @livewire("home.partials.newsletter")
</main>