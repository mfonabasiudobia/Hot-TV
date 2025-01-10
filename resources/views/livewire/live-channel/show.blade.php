<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'HTS Live Channel', 'route' => null ]]" />
    <div class="container">


        <section>
           <section class="w-full max-h-screen relative">
                <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"></video>
                <div class="custom-loader absolute left-[45%] top-[45%]" id="loading-button"></div>
           </section>

            <div class="space-y-7">
                <div class="border-b">
                    <button class="p-3 px-5 border-b-2 border-danger relative top-[1px]">Description:</button>
                </div>
                <section class="space-y-5" id="description"></section>
            </div>
        </section>
    </div>
</div>


@push('script')
    <script>
        const videoPlayer = document.getElementById('player');

        var start_time = 0;

        document.addEventListener('DOMContentLoaded', () => {
                const player = new Plyr('#player', {
                    muted : true,
                    controls: ['play', 'volume', 'fullscreen'],
                    hideControls: false,
                    autoplay: true, // Autoplay is initially set to false
                });

                // Listen for the "play" event
                player.on("play", function() {
                    videoPlayer.currentTime = start_time;
                });

        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentVideoSrc = '';
        function playVideo(data) {
            const description = document.getElementById("description");
            description.innerHTML = data.description;

            if(currentVideoSrc != data.src){
                videoPlayer.muted = true;
                videoPlayer.src = data.src;
                currentVideoSrc = data.src;

                videoPlayer.load();

                videoPlayer.currentTime = data.start_time;

                videoPlayer.play();

                setTimeout(() => {
                    videoPlayer.muted = false;
                }, 3000);
            }

        }

        //Subscribe to public.tv-channel.1 channel and listen for NewOrder events
        window.Echo.channel(`tv-channel`)
        .subscribed(() => {
            console.log("Echo connected to PieSocket channel!");
        })
        .listen('.tv-channel', (data) => {
            console.log("New Subscription Data", data);

            playVideo(data);

            start_time = data.start_time;

            if(!data.src){
                //Show loading button when Src is not there
                document.getElementById("loading-button").classList.remove("hidden");
            }else{
                document.getElementById("loading-button").classList.add("hidden");
            }
        });

    });
    </script>
@endpush

@push('header')
<style>
    :root {
        --plyr-color-main: #FF0207;
    }

    .custom-loader {
        width:50px;
        height:50px;
        border-radius:50%;
        padding:1px;
        background:conic-gradient(#0000 10%,#FF0207) content-box;
        -webkit-mask:
        repeating-conic-gradient(#0000 0deg,#000 1deg 20deg,#0000 21deg 36deg),
        radial-gradient(farthest-side,#0000 calc(100% - 9px),#000 calc(100% - 8px));
        -webkit-mask-composite: destination-in;
        mask-composite: intersect;
        animation:s4 2s infinite steps(10);
    }
    @keyframes s4 {to{transform: rotate(1turn)}}

</style>
@endPush
