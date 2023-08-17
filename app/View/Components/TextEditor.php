<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextEditor extends Component
{
    
    public $modelName, $alpineModel;

    public function __construct($model, $alpineModel = null)
    {
        $this->modelName = $model;
        $this->alpineModel = $alpineModel;
    }


    public function render()
    {
        return view('components.text-editor');
    }
}
