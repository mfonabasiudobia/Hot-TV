<?php

namespace App\Http\Livewire\User\Watchlist;

use App\Http\Livewire\BaseComponent;
use App\Models\Watchlist;;

class Home extends BaseComponent
{
    public function render()
    {
        $watchlists = Watchlist::where('user_id', auth()->id())->paginate(12);

        return view('livewire.user.watchlist.home', compact('watchlists'));
    }
}
