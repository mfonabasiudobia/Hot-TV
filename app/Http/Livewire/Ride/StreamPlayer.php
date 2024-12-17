<?php

namespace App\Http\Livewire\Ride;

use Livewire\Component;
use App\Models\Ride;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;

class StreamPlayer extends Component
{
    public $rideId;
    public $channelName;
    public $token;

    public function mount($rideId)
    {
        $this->rideId = $rideId;

        // Fetch the Ride model
        $ride = Ride::findOrFail($this->rideId);
        $this->channelName = $ride->stream_channel_name;

        // Generate Agora Token
        $this->token = $this->generateAgoraToken($this->channelName);
    }

    private function generateAgoraToken($channelName)
    {
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $uid = 0;
        $role = RtcTokenBuilder::RoleSubscriber;
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
        return view('livewire.stream-player');
    }
}
