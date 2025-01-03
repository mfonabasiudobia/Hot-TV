<?php

namespace App\Events;

use App\Http\Resources\Api\V1\Customer\Ride\RideResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RidePaymentSucceeded implements ShouldBroadcastNow
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

        \Log::info('ride.payment.succeeded', ['ride' => $ride]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.' . $this->ride->driver_id);
    }

    public function broadcastAs()
    {
        return ('ride.payment.succeeded');
    }
}
