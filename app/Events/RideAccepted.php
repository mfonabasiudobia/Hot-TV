<?php

namespace App\Events;

use App\Http\Resources\Api\V1\Customer\Ride\RideResource;
use App\Http\Resources\Api\V1\Customer\Ride\DriverResource;
use App\Http\Resources\Api\V1\Customer\Ride\CustomerResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ride;
use App\Models\User;

class RideAccepted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    public $driver;
    public $customer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride, $driver, $customer)
    {
        $this->ride = new RideResource($ride);
        $this->driver = new DriverResource($driver);
        $this->customer = new CustomerResource($customer);

        \Log::info('ride.accepted', ['ride' => $ride->id, 'driver', $driver->id, 'customer' => $customer->id]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('customer.'. $this->customer->id);
    }

    public function broadcastAs()
    {
        return 'ride.accepted';
    }
}
