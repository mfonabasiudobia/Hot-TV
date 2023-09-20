<?php

namespace App\Http\Livewire\Admin\Cast;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;

class Create extends BaseComponent
{

    public $name, $role, $image;

    public function mount($tvslug){
        $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
    }

    public function submit(){
            $this->validate([
                'name' => 'required|string',
                'role' => 'required',
                'image' => 'required'
            ]);

            try {

                $data = [
                    'name' => $this->name,
                    'role' => $this->role,
                    'image' => $this->image,
                    'tv_show_id' => $this->tvshow->id
                ];

                throw_unless(CastRepository::createCast($data), "Please try again");

                toast()->success('A new Cast has been added')->pushOnNextPage();

                return redirect()->route('admin.tv-show.show', ['slug' => $this->tvshow->slug ]);

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->push();
            }
    }

    public function render()
    {
        return view('livewire.admin.cast.create')->layout('layouts.admin-base');
    }
}
