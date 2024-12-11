<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{

    public $items;

    public function __construct(LengthAwarePaginator $items)
    {
        $this->items = $items;

    }

    public function render()
    {
        return view('components.pagination');
    }
}
