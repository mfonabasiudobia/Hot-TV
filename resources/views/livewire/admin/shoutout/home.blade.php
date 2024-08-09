<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Shoutouts</h1>

        <a href="{{ route('admin.shoutout.create') }}" class="bg-danger action-btn">Add Shoutout</a>
    </section>

    @livewire('admin.shoutout.tables.home', key($key))
</section>
