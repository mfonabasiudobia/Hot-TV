<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;

class PrivacyPolicy extends Component
{
    public $page;

    public function mount(){
        $this->fill([
            'page' => Page::where('name', 'Our Cookies Policy - Privacy Policy')->first()
        ]);
    }

    public function render()
    {
        return view('livewire.privacy-policy');
    }
}
