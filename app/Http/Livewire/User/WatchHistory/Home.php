<?php

namespace App\Http\Livewire\User\WatchHistory;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\TvShowView;

class Home extends Component
{
    public function render()
    {
        $user = Auth::user();
        $tvShows = TvShowView::where('user_id', $user->id)->groupBy('tv_show_id')->selectRaw('tv_show_views.tv_show_id')->paginate(12);
        return view('livewire.user.watch-history.home', compact('tvShows'));
    }
}
