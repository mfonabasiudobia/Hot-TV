<main>
    @livewire("admin.gallery.modal.create")
    <section class="content-wrapper">
        <x-loading />

        <section class="flex justify-between items-center">
            <h1 class="title">Gallery</h1>

            <button class="bg-primary action-btn" wire:click="$emit('openGallery')">Add New File</button>
        </section>
        @livewire('admin.gallery.tables.home', key($key))
    </section>
</main>