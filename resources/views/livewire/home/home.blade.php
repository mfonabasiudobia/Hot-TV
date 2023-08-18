<main class="min-h-screen text-white">
  <section style="background-image: url('{{ asset('images/background-image-01.png') }}">
    <section class="py-16">
      <div class="container grid md:grid-cols-2 gap-10">
        <section class="space-y-7 md:order-1 order-2">
          <div class="flex items-center space-x-5">
            <button class="text-danger">
              Live Channel
            </button>
    
            <button>
              Pedicab Streams
            </button>
    
            <button>Tv Shows</button>
          </div>
          <h1 class="font-extrabold text-5xl">HTS Live Channel</h1>
          <div class="space-y-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna
              aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
    
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna
              aliqua.</p>
          </div>
    
          <div class="flex items-center space-x-5">
            <button class="btn btn-danger btn-lg rounded-xl py-3 flex justify-between items-center space-x-5">
              <span>Watch Now</span>
    
              <i class="las la-play"></i>
            </button>
    
            <button class="btn border btn-lg rounded-xl py-3">
              Add to Watchlist
            </button>
          </div>
        </section>
    
        <section class="order-1 md:order-2">
          <img src="{{ asset('images/coverFilm.png') }}" alt="" />
        </section>
      </div>
    </section>
    
    @livewire("home.partials.recently-watch")
  </section>
  

    <section style="background-image: url('{{ asset('images/newsletter-background.png') }}" class="py-16">
        <div class="container">
            <div class="md:w-2/5 mx-auto space-y-7">
              <h1 class="font-semibold text-xl md:text-3xl text-center">
                Subscribe our newsletter for newest Tv shows updates
              </h1>

              <form class="flex items-center space-x-3">
                <div class="form-group w-full">
                  <input 
                    type="text" 
                    placeholder="Type your email here" 
                    class="form-control border-0 rounded-xl py-4 px-5 bg-[#F3F3F3] bg-opacity-20" 
                  />
                </div>
                <div class="form-group">
                  <button class="text-danger bg-white py-4 px-5 rounded-xl font-semibold text-sm">
                    SUBSCRIBE
                  </button>
                </div>
              </form>
            </div>
        </div>
    </section>
</main>