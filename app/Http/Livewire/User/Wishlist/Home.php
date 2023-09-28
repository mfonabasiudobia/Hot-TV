<?php

namespace App\Http\Livewire\User\Wishlist;

use App\Http\Livewire\BaseComponent;
use Botble\Ecommerce\Models\Wishlist;
use App\Http\Traits\Ecommerce;

class Home extends BaseComponent
{

    use Ecommerce;
    
    public function render()
    {
        $wishlists = Wishlist::where('customer_id', auth()->id())->paginate(12);

        return view('livewire.user.wishlist.home', compact('wishlists'));
    }
}
