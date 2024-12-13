<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ride;
use App\Models\User;

class RideRequestEvent implements ShouldBroadcast
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
    public function __construct(Ride $ride, User $driver, $customer_id)
    {
        $this->ride = $ride;
        $this->driver = $driver;
        $this->customer_id = $customer_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('ride-request.' . $this->drive->id);
    }

    public function broadcastAs()
    {
        return 'ride.requested';
    }
}
