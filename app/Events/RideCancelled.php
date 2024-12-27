<?php

namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideCancelled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ride $ride)
    {
        $this->ride = $ride;

        \Log::info('ride.cancelled', ['ride_id' => $ride->id, 'customer_id' => $ride->user_id]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.' . 87); // $this->ride->driver_id
    }

    public function broadcastAs()
    {
        return 'ride.cancelled';
    }
}
