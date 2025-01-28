<?php

namespace App\Http\Livewire\Admin\Jobs;

use Livewire\Component;

class JobProgress extends Component
{
    public $showToast = false;
    public $progress = 0;
    public $jobId;

    protected $listeners = ['jobProgressUpdated'];

    public function jobProgressUpdated($jobId, $percentage)
    {
        $this->progress = $percentage;
        $this->jobId = $jobId;
        $this->showToast = true;
    }

    public function render()
    {
        return view('livewire.admin.jobs.job-progress');
    }
}
