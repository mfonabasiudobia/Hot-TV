<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'HTS Live Channel', 'route' => null ]]" />
    <div class="container">
       

        <section>
            {{-- <img src="{{ asset('images/live-video.png') }}" alt=""> --}}

            <video id="videoPlayer" controls autoplay loop style="width: 100%;"></video>

            <div class="space-y-7">
                <div class="border-b">
                    <button class="p-3 px-5 border-b-2 border-danger relative top-[1px]">Description:</button>
                </div>
                <section class="space-y-5">
                    <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web,
                        precisamos
                        desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos
                        encontrar
                        como desenvolvedores e desenvolvedoras web. Muito bem vamos diretos entender os fundamentos. Esse curso tem como
                        objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web, precisamos desse
                        conhecimento
                        para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos encontrar como
                        desenvolvedores e
                        desenvolvedoras web. Muito bem vamos diretos entender os fundamentos.</p>
                
                    <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web,
                        precisamos
                        desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos
                        encontrar
                        como desenvolvedores e desenvolvedoras web. Muito bem vamos diretos entender os fundamentos. Esse curso tem como
                        objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web, precisamos desse
                        conhecimento
                        para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos encontrar como
                        desenvolvedores e
                        desenvolvedoras web. Muito bem vamos diretos entender os fundamentos.</p>
                
                    <p>Esse curso tem como objetivo de te dar os
                        fundamentos da programação e entender um pouco mais sobre o web, precisamos desse conhecimento para então nos
                        tornarmos
                        aptos a estudar as diversas linguagens e tecnologias que vamos encontrar como desenvolvedores e desenvolvedoras
                        web.
                        Muito bem vamos diretos entender os fundamentos. Esse curso tem como objetivo de te dar os fundamentos da
                        programação e
                        entender um pouco mais sobre o web, precisamos desse conhecimento para então nos tornarmos aptos a estudar as
                        diversas
                        linguagens e tecnologias que vamos encontrar como desenvolvedores e desenvolvedoras web. Muito bem vamos diretos
                        entender os fundamentos. Esse curso tem como objetivo de te dar os fundamentos da programação e entender um
                        pouco mais
                        sobre o web, precisamos desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e
                        tecnologias
                        que vamos encontrar como desenvolvedores e desenvolvedoras web. Muito bem vamos diretos entender os fundamentos.
                    </p>
                
                    <p>Esse curso tem como objetivo de te dar os fundamentos da programação e entender um pouco mais sobre o web,
                        precisamos
                        desse conhecimento para então nos tornarmos aptos a estudar as diversas linguagens e tecnologias que vamos
                        encontrar
                        como desenvolvedores e desenvolvedoras web. Muito bem vamos diretos entender os fundamentos.</p>
                </section>
            </div>
        </section>
    </div>
</div>

@push('script')    
    <script>
        // Define an array of video sources
            const videoSources = [
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
            ];
    
            // Define the schedule times (in 24-hour format)
            const scheduleTimes = [
                { start: 0, end: 1 },  // 12AM-1AM
                { start: 1, end: 2 },  // 1AM-2AM
                { start: 2, end: 3 },  // 2AM-3AM
                { start: 3, end: 4 }, // 3AM-4AM
                { start: 4, end: 5 }, // 4AM-5AM
                { start: 5, end: 6 }, // 5AM-6AM
                { start: 6, end: 7 }, // 6AM-7AM
                { start: 7, end: 8 }, // 7AM-8AM
                { start: 8, end: 8.666666666666666 }, // 8AM-8.10Am
                { start: 8.666666666666666, end: 9 }, // 8AM-9AM
                { start: 9, end: 10 }, // 9AM-10AM
                { start: 10, end: 11 }, // 10AM-11AM
            ];
    
            // Function to play the video at the specified index
            function playVideo(index) {
                const videoPlayer = document.getElementById("videoPlayer");
                videoPlayer.src = videoSources[index];
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
                        console.log(i)
                        playVideo(i); 
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