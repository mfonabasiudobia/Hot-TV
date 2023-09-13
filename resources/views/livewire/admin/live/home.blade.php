<section>
    {{-- <video class='w-screen h-screen' controls>
        <source src='{{ asset($video->recorded_video) }}'>
        Your browser does not support HTML5 video.
    </video> --}}

    <video id="player" playsinline controls poster="https://bitdash-a.akamaihd.net/content/sintel/poster.png">
        <source src="{{ asset('storage/hijack.mkv') }}">
    </video>
</section>


@push('script')
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const player = new Plyr('#player', {
                autoplay: false, // Autoplay is initially set to false
            });
            
            setTimeout(() => {
                // Define the new video source
                const newSource = "{{ asset('storage/hijack.mkv') }}";
                
                // Update the video source
                const videoPlayer = document.getElementById('player');
                videoPlayer.src = newSource;
                
                // Reload the Plyr player to apply changes
                player.load();
                player.play();
            }, 10000)
        });
    </script>
@endpush



@push('header')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
@endpush