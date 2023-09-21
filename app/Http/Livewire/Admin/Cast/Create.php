<?php

namespace App\Http\Livewire\Admin\Cast;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;

class Create extends BaseComponent
{

    public $name, $image;

    public function mount(){
        // $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
    }

    public function submit(){
            $this->validate([
                'name' => 'required|string',
                'image' => 'required'
            ]);

            try {

                $data = [
                    'name' => $this->name,
                    'image' => $this->image,
                ];

                throw_unless(CastRepository::createCast($data), "Please try again");

                toast()->success('A new Cast has been added')->pushOnNextPage();

                return redirect()->route('admin.tv-show.cast.list');

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->push();
            }
    }

    public function render()
    {
        return view('livewire.admin.cast.create')->layout('layouts.admin-base');
    }
}
