<?php

namespace App\Http\Livewire\Admin\ShowCategory;

use App\Http\Livewire\BaseComponent;
use App\Repositories\CategoryRepository;
use App\Models\ShowCategory;

class Create extends BaseComponent
{
        public $name, $slug, $order;

        public function updatedName(){
            $this->slug = str()->slug($this->name);
        }

        public function submit(){
    
            $this->validate([
                'name' => 'required',
                'order' => 'required'
            ]);


            $data = [
                'name' => $this->name,
                'order' => $this->order,
                'slug' => $this->slug
            ];

            try {

                throw_unless(ShowCategory::create($data), 'An error occured, please try again');

                $this->emit('refreshCategory');

                $this->reset();

                toast()->success('Category has been created')->push();

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->push();
            }
    }   


    public function render()
    {
        return view('livewire.admin.show-category.create')->layout('layouts.admin-base');
    }
}
