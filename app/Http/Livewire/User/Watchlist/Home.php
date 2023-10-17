<?php

namespace App\Http\Livewire\User\Watchlist;

use App\Http\Livewire\BaseComponent;
use App\Models\Watchlist;;
use App\Models\TvShow;

class Home extends BaseComponent
{
    public function render()
    {
        $watchlists = Watchlist::where('user_id', auth()->id())->where('watchable_type', TvShow::class)->paginate(12);

        return view('livewire.user.watchlist.home', compact('watchlists'));
    }
}
