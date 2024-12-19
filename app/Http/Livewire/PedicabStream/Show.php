<?php

namespace App\Http\Livewire\PedicabStream;

use Livewire\Component;
use App\Models\Ride;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;

class Show extends Component
{
    public $ride;
    public $channelName;
    public $token;

    public function mount(Ride $ride)
    {
        $this->ride = $ride;
        // $ride = Ride::findOrFail($this->rideId);

        $this->channelName = $ride->stream_channel_name;
        // $this->channelName = 'stream-87-149';
        $this->token = $this->generateAgoraToken($this->channelName);
    }

    private function generateAgoraToken($channelName)
    {
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $role = RtcTokenBuilder::RoleSubscriber;
        $uid = auth('api')->id();
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

    public function render()
    {
        return view('livewire.pedicab-stream.show');
    }
}
