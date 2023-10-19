<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Podcasts</h1>

        <a href="{{ route('admin.podcast.create') }}" class="bg-danger action-btn">Add Podcast</a>
    </section>

    @livewire('admin.podcast.tables.home', key($key))
</section>