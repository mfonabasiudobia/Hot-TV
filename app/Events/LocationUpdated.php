<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $latitude;
    public $longitude;
    public $recipient;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $latitude, $longitude, $recipient = 'admin')
    {
        $this->userId = $userId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->recipient = $recipient;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->recipient == 'driver') {
            return new PrivateChannel('driver.' . $this->userId);
        } elseif ($this->recipient == 'customer') {
            return new PrivateChannel('customer.' . $this->userId);
        }

        return new PrivateChannel('admin-location');
    }

    public function broadcastAs()
    {
        return ('location.updated');
    }
}
