<section class="content-wrapper">
    <section class="flex justify-between items-center">
        <h1 class="title">Seasons</h1>

        <a href="{{ route('admin.tv-show.season.create') }}"
           class="bg-danger action-btn">Add Season</a>
    </section>
    @livewire('admin.season.tables.home', key($key))
</section>
