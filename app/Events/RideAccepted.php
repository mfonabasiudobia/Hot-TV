<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    public $driver;
    public $customer_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ride $ride, User $driver)
    {
        $this->ride = $ride;
        $this->driver = $driver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(`ride-request.${$this->ride->user_id}`);
    }

    public function broadcastAs()
    {
        return ('ride.accepted');
    }
}
