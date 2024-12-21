<?php

namespace App\Events;

use App\Http\Resources\Api\V1\Customer\Ride\RideResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoDriverFound implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride)
    {
        $this->ride = new RideResource($ride);

        \Log::info('ride.driver.not.found', ['ride_id' => $ride->id, 'customer_id' => $ride->customer_id]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('customer.'. $this->ride->customer->id);
    }

    public function broadcastAs()
    {
        return ('ride.driver.not.found');
    }
}
