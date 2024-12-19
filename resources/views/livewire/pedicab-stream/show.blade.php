<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[
                ['title' => 'Pedicab Stream', 'route' => route('home') ],
                ['title' => `ride` . $ride->id, 'route' => null]
    ]" />
     <div class="container space-y-7">

        <section class="grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-7 overflow-hidden">

                <div class="video-container" wire:ignore>
                    <div id="stream-container" style="width: 800px; height: 600px; background-color: black;">
                        <div id="remote-video" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>

                <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                    <div class="flex items-center justify-between">
                    </div>

                    <div class="flex flex-col items-end space-y-5">
                        <button>
                            <img src="{{ asset('svg/3-dots-horizontal.svg') }}" alt="" />
                        </button>

                        <div class="flex items-center space-x-3">

                        </div>
                    </div>
                </header>
            </div>
        </section>
    </div>
</div>

@push('script')
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const appId = "{{ env('AGORA_APP_ID') }}"; // Agora App ID
        const channelName = "{{ $channelName }}"; // Channel Name from Livewire
        const token = "{{ $token }}"; // Agora Token from Livewire
        const uid = 0; // Auto-assigned User ID

        const client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });

        async function playStream() {
            try {
                await client.join(appId, channelName, token, uid);
                console.log("Joined the channel successfully");

                client.on("user-published", async (user, mediaType) => {
                    await client.subscribe(user, mediaType);
                    console.log("Subscribed to remote user");

                    if (mediaType === "video") {
                        // Play Video Stream
                        user.videoTrack.play("remote-video");
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

        playStream();
    });
</script>
@endPush

