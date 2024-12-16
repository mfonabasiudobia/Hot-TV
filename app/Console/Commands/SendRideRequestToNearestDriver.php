<?php

namespace App\Console\Commands;

use App\Events\RideRequestEvent;
use App\Repositories\DriverRepository;
use Illuminate\Console\Command;
use App\Enums\Ride\StatusEnum;
use App\Enums\Ride\DriverRideStatusEnum;
use Carbon\Carbon;

class SendRideRequestToNearestDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ride:send-request-to-nearest-driver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ride request to the nearest available driver';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rides = \App\Models\Ride::where('status', 'requested')->get();
        // TODO: save seconds in config file
        $timeLimit = Carbon::now()->subSeconds(20);

        foreach ($rides as $ride) {
            // every no of seconds defined in settings reject or accept will be called
            // if that is not called and this scheduled job runs then it can ovveride update status to rejected
            $ride->ride_responses()->where('ride_id', $ride->id)
            ->where('created_at', '<', $timeLimit)
            ->update([
                'status'=> DriverRideStatusEnum::AUTO_REJECTED
            ]);

            $driver = DriverRepository::getNextAvailableDriver($ride);

            if ($driver) {
                $driver->ride_responses()->create([
                    'ride_id' => $ride->id,
                    'status' => DriverRideStatusEnum::PENDING,
                ]);

                event(new RideRequestEvent($ride, $driver, $ride->customer));
            }else{
                // TODO: save minutes in config file
                $requestExpiredTime = Carbon::now()->subMinutes(10);
                if($ride->created_at >= $requestExpiredTime) {
                    $ride->status = StatusEnum::NO_DRIVER_FOUND;
                    $ride->save();
                }
            }
        }

        $this->info('Ride requests have been dispatched to the queue.');
    }
}
