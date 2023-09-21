<?php

namespace App\Http\Livewire\Admin\Cast;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;

class Edit extends BaseComponent
{

    public $name, $image;

    public $tvshow, $cast;

    public function mount($id){
        $this->cast = CastRepository::getCastById($id);

        $this->fill([
            'name' => $this->cast->name,
            'image' => $this->cast->image
        ]);
    }

    public function submit(){
            $this->validate([
                'name' => 'required|string',
                'image' => 'required'
            ]);

            try {

                $data = [
                    'name' => $this->name,
                    'image' => $this->image
                ];

                throw_unless(CastRepository::updateCast($data, $this->cast->id), "Please try again");

                toast()->success('Cast has been updated')->pushOnNextPage();

                return redirect()->route('admin.tv-show.cast.list');

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->push();
            }
    }

    public function render()
    {
        return view('livewire.admin.cast.edit')->layout('layouts.admin-base');
    }
}
