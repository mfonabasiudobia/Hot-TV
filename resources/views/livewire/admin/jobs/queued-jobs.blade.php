<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Queued Jobs</h1>

        <!-- <a href="{{ route('admin.show-category.create') }}" class="bg-danger action-btn">Add Show Category</a> -->
    </section>

    @livewire('admin.jobs.tables.home')
</section>
