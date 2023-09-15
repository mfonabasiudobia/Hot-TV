<?php

namespace App\Http\Livewire\Admin\ShowCategory;

use App\Http\Livewire\BaseComponent;
use App\Repositories\ShowCategoryRepository;

class Edit extends BaseComponent
{

    public $category, $name, $slug, $order;


    public function mount($id){
        $this->category = ShowCategoryRepository::getShowCategoryById($id);

        $this->fill([
            'name' => $this->category->name,
            'slug' => $this->category->slug,
            'order' => $this->category->order,
        ]);
        
    }

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
            'slug' => $this->slug,
            'order' => $this->order
        ];

        try {

            throw_unless(ShowCategoryRepository::updateShowCategory($data, $this->category->id), 'An error occured, please try again');

            toast()->success('Category has been updated')->push();

            redirect()->route('admin.show-category.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.show-category.edit')->layout('layouts.admin-base');
    }
}
