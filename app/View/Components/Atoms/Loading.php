<?php

namespace App\View\Components\Atoms;

use Illuminate\View\Component;

class Loading extends Component
{
     public $class, $target;

     public function __construct($target)
     {
        // $this->class = $class;
        $this->target = $target;
     }

    public function render()
    {
        return view('components.atoms.loading');
    }
}
