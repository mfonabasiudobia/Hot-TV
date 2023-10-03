<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;

class Home extends Component
{

    public $page;

    public function mount(){
        $slug = Slug::where('key', "homepage")->firstorFail();

        $this->page = Page::findOrFail($slug->reference_id);
    }

    public function render()
    {
        return view('livewire.home.home');
    }
}
