<?php

namespace App\Http\Livewire\ShoutOuts;

use App\Models\Shoutout;
use Botble\Base\Enums\BaseStatusEnum;
use Livewire\Component;

class Home extends Component
{

    public $perPage = 3;

    public function loadMore()
    {
        $this->perPage += 3;
        $this->render();
    }
    public function render()
    {


        $shoutouts = Shoutout::where('status', BaseStatusEnum::PUBLISHED()->getValue())
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.shout-outs.home')->with('shoutouts', $shoutouts);
    }
}
