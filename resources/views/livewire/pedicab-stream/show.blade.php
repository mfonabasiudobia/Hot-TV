<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => 'Pedicab Stream', 'route' => route('home') ],
                ['title' => `ride` . $ride->id, 'route' => null]
    ]" />
     <div class="container space-y-7">

        <section class="grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-7 overflow-hidden relative">

                @if (! (bool) $ride->is_stream_blocked)
                    <div class="video-container" wire:ignore>
                        <div id="stream-container" style="min-width: 800px; height: 500px; background-color: black;">
                            <video id="remote-video" controls playsinline style="width: 100%; height: 100%;"></video>

                        </div>
                    </div>
                @endif

                @if ($ride->stream_status === 'pending')
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2
                        backdrop-blur bg-secondary text-white flex items-center justify-center rounded-lg"
                        style="top: 180px; width: 300px; height: 150px;">
                        <p class="text-center">waiting for streaming to start</p>
                    </div>
                @endif

                @if ($ride->stream_status === 'completed')
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2
                        backdrop-blur bg-secondary text-white flex items-center justify-center rounded-lg"
                        style="top: 180px; width: 300px; height: 150px;">
                        <p class="text-center"> streaming ended </p>
                    </div>
                @endif

                <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <h2 class="font-semibold text-xl">{{ $ride->street_name  }}</h2>
                        </div>
                    </div>

                    <div>
                        <i class="lar la-eye"></i>
                        @if($ride->stream_status === 'streaming')
                            <span>{{ view_count($ride->watching) }} watching</span>
                        @else
                            <span>{{ view_count($ride->views) }} views</span>
                        @endIf
                    </div>
                </header>

                <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <h2 class="font-semibold text-xl">Customer: {{ $ride->customer->first_name }} {{ $ride->customer->last_name }}</h2>
                        </div>
                    </div>

                    <div>
                        <i class="lar la-eye"></i>
                        <span>{{ $ride->customer->email }}</span>
                    </div>
                </header>
            </div>
        </section>
    </div>
</div>

@push('script')
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    window.addEventListener("beforeunload", () => {
        Livewire.emit('userLeft');
    });

    const defaultOptions = {
        muted : true,
        autoplay: true,
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions'],
        settings: ['captions', 'quality'],
        quality: {
            default: 720,
            options: [360, 480, 720, 1080],
            forced: true,
            onChange: (quality) => {
                console.log(`Selected quality: ${quality}`);
            }
        }
    };


    document.addEventListener('DOMContentLoaded', function () {
        const isBlocked = "{{ $ride->is_stream_blocked }}";
        if(isBlocked == 1) return false;

        const appId = "{{ env('AGORA_APP_ID') }}"; // Agora App ID
        const channelName = "{{ $channelName }}"; // Channel Name from Livewire
        const token = "{{ $token }}"; // Agora Token from Livewire
        const uid = 1; // Auto-assigned User ID

        const client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });

        async function playStream() {
            try {
                await client.join(appId, channelName, token, uid);
                console.log("Joined the channel successfully");

                client.on("user-published", async (user, mediaType) => {
                    await client.subscribe(user, mediaType);
                    console.log("Subscribed to remote user");

                    if (mediaType === "video") {
                        const videoElement = document.getElementById("remote-video");

                        // Play Video Stream
                        user.videoTrack.play(videoElement);
                        const mediaStream = user.videoTrack.getMediaStreamTrack();
                        // const stream = new MediaStream([mediaStream]);
                        // videoElement.srcObject = stream;

                        // const player = new Plyr(videoElement, {
                        //     muted : true,
                        //     autoplay: true,
                        //     controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                        //     settings: ['captions', 'quality', 'speed', 'loop'],
                        // });

                        // player.on("play", () => {
                        //     videoElement.play();
                        // //     console.log(`Playing remote video for user: ${user.uid}`);
                        // });

                        // Optional: Listen for Plyr's other events
                        // player.on("pause", () => {
                        //     console.log("Video paused");
                        // });

                        console.log(`Playing remote video for user: ${user.uid}`);
                    }

                    if (mediaType === "audio") {
                        user.audioTrack.play();
                    }
                });

                // Handle User Unpublished Event
                client.on("user-unpublished", user => {
                    console.log(`User ${user.uid} has stopped publishing`);
                });

            } catch (error) {
                console.error("Error initializing Agora stream:", error);
            }
        }
        // debugger
        playStream();
    });
</script>
@endPush

