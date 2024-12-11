<?php

namespace App\Http\Livewire\User\Screenshots;

use App\Http\Livewire\BaseComponent;
use Botble\Gallery\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class Home extends BaseComponent
{

    public $galleries = [];
    public function mount()
    {
        $user = Auth::user();
        $this->galleries = Gallery::where('user_id', $user->id)
            ->orderBy('created_at')->get();
    }
    public function render()
    {

        return view('livewire.user.screenshots.home');
    }
}
