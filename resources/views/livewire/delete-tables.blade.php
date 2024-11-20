<div class="container mt-5">
    <h1>Delete All Database Tables</h1>
    <p class="text-danger">
        <strong>Warning:</strong> This action will permanently delete all database tables. Please proceed with caution.
    </p>

    {{-- Flash messages --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Confirmation prompt --}}
    @if($confirmation)
        <div class="alert alert-warning">
            <p>Are you sure you want to delete all tables?</p>
            <button wire:click="deleteAllTables" class="btn btn-danger">Yes, Delete All</button>
            <button wire:click="$set('confirmation', false)" class="btn btn-secondary">Cancel</button>
        </div>
    @else
        <button wire:click="$set('confirmation', true)" class="btn btn-danger">Delete All Tables</button>
    @endif
</div>
