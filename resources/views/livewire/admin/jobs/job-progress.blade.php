<div x-data="{ showToast: false, progress: 0 }"
     x-cloak
     @job-progress-updated.window="showToast = true; progress = $event.detail.progress;
         if (progress === 100) {
             setTimeout(() => { showToast = false }, 3000);
         }">
    <!-- Toast Notification -->
    <div x-show="showToast"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform ease-in duration-300 transition"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-4 opacity-0"
         class="fixed bottom-5 right-5 p-4 bg-blue-600 text-white rounded-lg shadow-lg flex items-center space-x-3 w-72">
        <div>
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m-6 0a9 9 0 110-18 9 9 0 010 18z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold">Job Progress</p>
            <p>Progress: <span x-text="progress"></span>%</p>
        </div>
    </div>

    <!-- Optional Content -->
    <div>
        <!-- Add your page content here -->
    </div>
</div>


@push('script')
<script>
    document.addEventListener('livewire:load', function () {
        const jobId = 1; // @json($jobId);

        Echo.private(`job-progress`)
            .listen('.job-progress', (e) => {
                Livewire.emit('jobProgressUpdated', event.jobId, event.progress);
                alert('notification recieved')
            });
    });
</script>
