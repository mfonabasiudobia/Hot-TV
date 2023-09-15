<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Show Categories</h1>

        <a href="{{ route('admin.show-category.create') }}" class="bg-primary action-btn">Add Show Category</a>
    </section>
    
    @livewire('admin.show-category.tables.home', key($key))
</section>