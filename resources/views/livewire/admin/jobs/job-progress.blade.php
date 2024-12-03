<div x-data="{ progress: 0, showToast: false }" x-init="Echo.private('job-processing.{{ $jobId }}')
        .listen('JobProgress', (event) => {
            showToast = true;
            if (progress === 100) {
                showToast = false;
            }
        })">
    <!-- Toast Notification -->
    <div x-show="showToast" x-transition x-cloak class="fixed bottom-5 right-5 p-4 bg-blue-500 text-white rounded-lg">
        <p>Progress: <span x-text="progress"></span>%</p>
    </div>

    <!-- Content of the page (optional) -->
    <div>
        <!-- Other content goes here -->
    </div>
</div>

@push('script')
<script>
    document.addEventListener('livewire:load', function () {
        const jobId = @json($jobId);

        Echo.private(`video-processing.${jobId}`)
            .listen('.job-progress', (e) => {
                Livewire.emit('jobProgressUpdated', e.percentage);
                alert('notification recieved')
            });
    });
</script>
