<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;

class Terms extends Component
{

    public $page;

    public function mount(){
        $this->fill([
            'page' => Page::where('name', 'Terms and Condition')->first()
        ]);
    }
    
    public function render()
    {
        return view('livewire.terms');
    }
}
