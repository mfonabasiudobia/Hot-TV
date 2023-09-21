<main class="space-y-7">

    <section class="content-wrapper">
        <section class="flex justify-between items-center">
            <h1 class="title">Casts</h1>

            <a href="{{ route('admin.tv-show.cast.create') }}"
                class="bg-danger action-btn">Add Cast</a> 
        </section>
        
        @livewire('admin.cast.tables.home', key($key))
    </section>
</main>