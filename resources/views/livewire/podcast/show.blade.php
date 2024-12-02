<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Podcast', 'route' => null ]]" />
    <div class="container">


        <section>
            <section class="w-full max-h-screen relative">
                <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"
                    src="{{ $podcast->video ? Storage::disk(\App\Enums\VideoDiskEnum::DISK->value)->url( \App\Enums\VideoDiskEnum::PODCASTS->value . $podcast->slug . '/' . $podcast->video->uuid . '.m3u8') : route('video-stream', ['podcast', $podcast->id]) }}"></video>

                <div id="registerMessage" style="display: none; text-align: center; margin-top: 20px;">
                    <h2>You have watched {{ setting('video_length') }} minute of this video.</h2>
                    <p>Please <a href="{{route('register')}}">register</a> or <a href="{{ route('login') }}">login</a> to watch the full video.</p>
                </div>
                <div class="custom-loader absolute left-[45%] top-[45%]" id="loading-button"></div>
            </section>

            <div class="space-y-7">
                <div class="border-b">
                    <button class="p-3 px-5 border-b-2 border-danger relative top-[1px]">Description:</button>
                </div>
                <section class="space-y-5" id="description">{!! $podcast->description !!}</section>
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
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
            const defaultOptions = {
                muted : true,
                autoplay: true,
                controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                settings: ['captions', 'quality', 'speed', 'loop'],
                quality: {
                    default: 720,
                    options: [360, 480, 720, 1080],
                    forced: true,
                    onChange: (quality) => {
                        console.log(`Selected quality: ${quality}`);
                    }
                }
            };

            // const player = new Plyr('#player', defaultOptions);
            const video = document.getElementById('player');
            const source = "{{ Storage::disk(\App\Enums\VideoDiskEnum::DISK->value)->url( \App\Enums\VideoDiskEnum::PODCASTS->value . $podcast->slug . '/' . $podcast->video->uuid . '.m3u8') }}";

            if (!Hls.isSupported()) {
                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } else {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);

                // From the m3u8 playlist, hls parses the manifest and returns
                // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
                hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
                    // Transform available levels into an array of integers (height values).
                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array
                    console.log('available qualities', hls.levels)
                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: 0, //Default - AUTO
                        options: availableQualities,
                        forced: true,        
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
                        var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })
            
                    // Initialize new Plyr player with quality options
                    var player = new Plyr(video, defaultOptions);
                });	

                hls.attachMedia(video);
                window.hls = hls;
            }

            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                } else {
                    window.hls.levels.forEach((level, levelIndex) => {
                    if (level.height === newQuality) {
                        console.log("Found quality match with " + newQuality);
                        window.hls.currentLevel = levelIndex;
                    }
                    });
                }
            }

            // player.addEventListener('timeupdate', function() {
            //     console.log(this.currentTime);
            //     if (this.currentTime >= {{ setting('video_length') }}) { // 60 seconds = 1 minute
            //         this.style.display = 'none';
            //         console.log('Video is paused');
            //         document.getElementById('registerMessage').style.display = 'block';
            //         this.pause();
            //     }
            // });
        });
</script>
