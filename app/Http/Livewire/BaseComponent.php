<?php 

namespace App\Http\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Http\Traits\DeleteItem;
use Usernotnull\Toast\Concerns\WireToast;

class BaseComponent extends Component
{

    use WithPagination, WithFileUploads, WireToast;

    protected $listeners = ['trashDelete', 'refresh' => '$refresh'];

    use DeleteItem;
    
}
