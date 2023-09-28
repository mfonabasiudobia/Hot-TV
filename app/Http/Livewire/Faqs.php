<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Botble\Faq\Models\Faq;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;

class Faqs extends Component
{

    public $faqs = [], $faq;

    public function mount(){
        $this->faqs = Faq::where('status', 'published')->get();

        $slug = Slug::where('key', "frequently-asked-questions")->firstorFail();

        $this->faq = Page::findOrFail($slug->reference_id);
    }

    public function render()
    {
        return view('livewire.faqs');
    }
}
