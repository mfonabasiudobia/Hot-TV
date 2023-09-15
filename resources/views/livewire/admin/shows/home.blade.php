<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">TV Shows</h1>

        <a href="{{ route('admin.tv-show.create') }}" class="bg-primary action-btn">Add TV Show</a>
    </section>

    @livewire('admin.shows.tables.home', key($key))
</section>