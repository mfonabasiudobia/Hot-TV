<main class="space-y-7">

    <section class="content-wrapper">
        <section class="flex justify-between items-center">
            <h1 class="title">Casts</h1>
    
            <a href="{{ route('admin.tv-show.cast.create', ['tvslug' => $tvshow->slug ]) }}"
                class="bg-primary action-btn">Add Cast</a>
        </section>
        @livewire('admin.cast.tables.home', ['tvshow' => $tvshow ], key($key))
    </section>

    <section class="content-wrapper">
        <section class="flex justify-between items-center">
            <h1 class="title">Episodes</h1>
    
            <a href="{{ route('admin.tv-show.episode.create', ['tvslug' => $tvshow->slug ]) }}"
                class="bg-primary action-btn">Add Episode</a>
        </section>
        @livewire('admin.episode.tables.home', ['tvshow' => $tvshow ], key($key))
    </section>
</main>