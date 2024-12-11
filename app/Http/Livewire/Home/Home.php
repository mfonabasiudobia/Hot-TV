<?php

namespace App\Http\Livewire\Home;

use App\Http\Livewire\BaseComponent;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;

class Home extends BaseComponent
{

    public $page;

    public function mount(){
        $slug = Slug::where('key', "homepage")->firstorFail();

        $this->page = Page::findOrFail($slug->reference_id);

    }

     public function saveToWatchlist($item){
        try {

            $watchlist =  $item->watchlists()->where('user_id', auth()->id())->first();

            if(!$watchlist){
                $watchlist = new Watchlist(['user_id' => auth()->id()]);

                $item->watchlists()->save($watchlist);

                return toast()->success('Added To My List')->push();
            }

            $watchlist->delete();

            toast()->success('Removed From My List')->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.home.home');
    }
}
