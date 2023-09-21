<section class="content-wrapper">
    <section class="flex justify-between items-center">
        <h1 class="title">Episodes</h1>

        <a href="{{ route('admin.tv-show.episode.create') }}"
            class="bg-danger action-btn">Add Episode</a>
    </section>
    @livewire('admin.episode.tables.home', key($key))
</section>