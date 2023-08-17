<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyList extends Component
{
    
    public $total;

    public function __construct(int $total)
    {
        $this->total = $total;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.empty-list');
    }
}
