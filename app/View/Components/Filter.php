<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filter extends Component
{

    public $showItems = [];

    public function __construct($showItems)
    {
        $this->showItems = $showItems;
    }


    public function render()
    {
        return view('components.filter');
    }
}
