<div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress" class="space-y-1">
    <!-- File Input -->
    {{ $slot }}

    <!-- Progress Bar -->
    <div x-show="isUploading" class="flex items-center space-x-2 text-sm">
        <progress max="100" x-bind:value="progress" class="w-full h-1 rounded-full bg-danger">
        </progress>
        <span x-text="progress"></span> %
    </div>
</div>