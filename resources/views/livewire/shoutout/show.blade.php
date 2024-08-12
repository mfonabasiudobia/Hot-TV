<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Shoutouts', 'route' => route('celebrity-shoutout.home') ]]" />
    <div class="container">


        <section>
            @if($shoutout->media_type == 'video')
                <section class="w-full max-h-screen relative">
                    <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"
                           src="{{ route('video-stream', ['shoutout', $shoutout->id]) }}"></video>
                    <div id="registerMessage" style="display: none; text-align: center; margin-top: 20px;">
                        <h2>You have watched {{ setting('video_length') }} minute of this video.</h2>
                        <p>Please <a href="{{route('register')}}">register</a> or <a href="{{ route('login') }}">login</a> to watch the full video.</p>
                    </div>
                    <div class="custom-loader absolute left-[45%] top-[45%]" id="loading-button"></div>
                </section>

            @else
                <section class="w-full max-h-screen relative">
                    <img src="{{ file_path($shoutout->media_url) }}" style="width: 100%;" class="max-h-screen" />
                </section>
            @endif

            <div class="space-y-7">
                <div class="border-b">
                    <button class="p-3 px-5 border-b-2 border-danger relative top-[1px]">Description:</button>
                </div>
                <section class="space-y-5" id="description">{!! $shoutout->description !!}</section>
            </div>
        </section>
    </div>
</div>

@push('header')
    <style>
        :root {
            --plyr-color-main: #FF0207;
        }
    </style>
@endPush


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const player = new Plyr('#player', {
                muted : true,
                autoplay: true, // Autoplay is initially set to false
            });

            player.addEventListener('timeupdate', function() {
                console.log(this.currentTime);
                if (this.currentTime >= {{ setting('video_length') }}) { // 60 seconds = 1 minute
                    this.style.display = 'none';
                    console.log('Video is paused');
                    document.getElementById('registerMessage').style.display = 'block';
                    this.pause();
                }
            });
        });
    </script>
