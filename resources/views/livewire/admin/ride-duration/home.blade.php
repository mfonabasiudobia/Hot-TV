<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Ride Durations</h1>

        <a href="{{ route('admin.ride.create-duration') }}" class="bg-danger action-btn">Add Ride Duration</a>

    </section>

    @livewire('admin.ride-duration.tables.home', key($key))
</section>
