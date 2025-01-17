<?php

namespace App\Http\Livewire\PedicabStream;

use App\Models\PedicabStreamView;
use Livewire\Component;
use App\Models\Ride;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;
use Illuminate\Support\Str;

class Show extends Component
{
    public $ride;
    public $channelName;
    public $token;
    public $ip;

    protected $listeners = ['userLeft' => 'userLeft'];


    public function mount(Ride $ride)
    {
        $this->ride = $ride;
        $this->channelName = $ride->stream_channel_name;

        if($this->channelName) {
            $this->token = $this->generateAgoraToken($this->channelName);
        }

        $this->ip = request()->ip() ?? '127.0.0.1';

        $streamView = PedicabStreamView::where('user_id',  auth()->id())
            ->where('ip_address',  $this->ip)
            ->where('ride_id', $this->ride->id)
            ->first();

        if (!$streamView) {
            PedicabStreamView::create([
                'user_id'=> auth()->id(),
                'ride_id'=> $this->ride->id,
                'status' => 'watching',
                'ip_address' => $this->ip,
            ]);
        } else {
            $streamView->status = 'watching';
            $streamView->save();
        }
    }

    private function generateAgoraToken($channelName)
    {
        $user = request()->user();

        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $role = RtcTokenBuilder::RoleSubscriber;
        $uid =  $user->id ?? Str::uuid();

        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->timestamp;
        $privilegeExpireTime = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUid(
            $appId,
            $appCertificate,
            $channelName,
            $uid,
            $role,
            $privilegeExpireTime
        );
    }


    public function userLeft()
    {
        logger("User left the page.");

        $streamView = PedicabStreamView::where('user_id',  auth()->id())
            ->where('ip_address',  $this->ip)
            ->where('ride_id', $this->ride->id)
            ->first();

        if ($streamView) {
            $streamView->status = 'left';
            $streamView->save();
        }
    }

    public function render()
    {
        return view('livewire.pedicab-stream.show');
    }
}
