<?php

namespace App\Http\Livewire\Admin\Jobs;

use DB;
use Livewire\Component;

class QueuedJobs extends Component
{
    // protected $listeners = ['echo:job-progress.1,job-progress' => 'updateJobProgress'];
    public $progress;
    public $jobId;
    public $title;

    public function getListeners()
    {
        return [
            "echo-private:job-progress.1,job-progress" => 'updateJobProgress',
        ];
    }

    public function updateJobProgress($jobId, $percentage, $title)
    {
        $this->jobId = $jobId;
        $this->progress = $percentage;
        $this->title = $title;
    }

    public function render()
    {
        $jobs = DB::table('jobs')->paginate(10);

        return view('livewire.admin.jobs.queued-jobs')->layout('layouts.admin-base');
    }
}
