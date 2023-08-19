<?php

namespace App\View\Components\Atoms;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $routes = [];

    public function __construct($routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.atoms.breadcrumb');
    }
}
