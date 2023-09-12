<section>
    {{-- <video class='w-screen h-screen' controls>
        <source src='{{ asset($video->recorded_video) }}'>
        Your browser does not support HTML5 video.
    </video> --}}

    <video id="player" playsinline controls poster="https://bitdash-a.akamaihd.net/content/sintel/poster.png">

          <source type="application/x-mpegURL" src="https://arbitos.kabadpalmsgolfresort.com/videos/playlist.m3u8">
        <!-- Captions are optional -->
        <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default />
    </video>


</section>


@push('script')
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        // const source = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
        
        // const source = "https://languagenectar.in/storage/questions/vidoes/ef8d6fec-ba6b-4f87-a1fe-9566097caa11.mp4";
        
        const video = document.querySelector('video');

        const source = video.getElementsByTagName("source")[0].src;
        
        const defaultOptions = {};
        
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
        });
    </script>
@endpush

@push('header')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
@endpush