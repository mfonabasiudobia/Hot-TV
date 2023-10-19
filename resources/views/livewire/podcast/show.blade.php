<div class="py-5 bg-black text-white space-y-5 min-h-screen">
    <x-atoms.breadcrumb :routes="[['title' => 'Podcast', 'route' => null ]]" />
    <div class="container">


        <section>
            <section class="w-full max-h-screen relative">
                <video id="player" controls autoplay loop playsinline style="width: 100%;" class="max-h-screen"
                    src="{{ file_path($podcast->recorded_video) }}"></video>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
                const player = new Plyr('#player', {
                    muted : true,
                    autoplay: true, // Autoplay is initially set to false
                });
        });
</script>