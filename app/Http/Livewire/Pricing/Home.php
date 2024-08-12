<?php

namespace App\Http\Livewire\Pricing;

use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Livewire\Component;

class Home extends Component
{

    public function mount()
    {
        $slug = Slug::where('key', "pricing")->firstorFail();

        $this->page = Page::findOrFail($slug->reference_id);
    }

    public function render()
    {
        return view('livewire.pricing.home');
    }
}
