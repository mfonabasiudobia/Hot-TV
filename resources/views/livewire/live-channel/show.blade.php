<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'HTS Live Channel', 'route' => null ]]" />
    <div class="container">
       

        <section>
            <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"></video>

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

        document.addEventListener('DOMContentLoaded', () => {
                const player = new Plyr('#player', {
                    autoplay: true, // Autoplay is initially set to false
                });
        });
    </script>
@endPush

@push('script')    
    <script>
            let currentVideoUrl = '';
        // Define an array of video sources
            // const videoSources = [
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            //     "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            //     "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            //     "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            // ];


            const videoSources = @json($infoArray);
    
            // Define the schedule times (in 24-hour format)
            // const scheduleTimes = [
            //     { start: 0, end: 1 },  // 12AM-1AM
            //     { start: 1, end: 2 },  // 1AM-2AM
            //     { start: 2, end: 3 },  // 2AM-3AM
            //     { start: 3, end: 4 }, // 3AM-4AM
            //     { start: 4, end: 5 }, // 4AM-5AM
            //     { start: 5, end: 6 }, // 5AM-6AM
            //     { start: 6, end: 7 }, // 6AM-7AM
            //     { start: 7, end: 8 }, // 7AM-8AM
            //     { start: 8, end: 8.666666666666666 }, // 8AM-8.10Am
            //     { start: 8.666666666666666, end: 9 }, // 8AM-9AM
            //     { start: 9, end: 10 }, // 9AM-10AM
            //     { start: 10, end: 11 }, // 10AM-11AM
            // ];

            //Constantly update the video url every 1 minutes using setInterval
            //Link Video Episodes in TV Channel
            //Show an image when there is no video
            //Try using web sockets instead of loop
            //Ask if the tv shows in home page is for pedicab stream or TV Shows 

            const scheduleTimes = @json($timeArray);

            // console.log(scheduleTimes);
    
            // Function to play the video at the specified index
            function playVideo(index) {
                const videoPlayer = document.getElementById("player");
                const description = document.getElementById("description");
                videoPlayer.src = videoSources[index].src;
                description.innerHTML = videoSources[index].description;
                videoPlayer.load();
                videoPlayer.play();
            }
    
            // Function to check the schedule and play videos
            function checkSchedule() {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinute = now.getMinutes() / 60;
                
                const currentTime = currentHour + currentMinute;
                
                for (let i = 0; i < scheduleTimes.length; i++) { 
                    const { start, end } = scheduleTimes[i]; 
                    if (currentTime>= start && currentTime < end) { 
                        if(currentVideoUrl !== videoSources[i].src){
                            playVideo(i);
                        }
                        
                        currentVideoUrl = videoSources[i].src;
                        break; 
                    } 
                }

                // Check the schedule every minute
                setTimeout(checkSchedule, 60000);
            }
    
            // Initial check
            checkSchedule();
    </script>
@endpush

@push('header')
    <style>
        :root {
            --plyr-color-main: #FF0207;
        }
    </style>
@endPush