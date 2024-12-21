<?php

namespace App\Events;

use App\Http\Resources\Api\V1\Customer\Ride\RideResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideAutoRejected implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    public $driver_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride, $driver_id)
    {
        $this->ride = new RideResource($ride);
        $this->driver_id = $driver_id;

        \Log::info('ride.auto.rejected', ['driver_id'=> $this->driver_id, 'ride_id' => $ride->id, 'customer_id' => $ride->customer_id]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.' . $this->driver_id);
    }

    public function broadcastAs()
    {
        return ('ride.auto.rejected');
    }
}
