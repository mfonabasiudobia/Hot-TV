<?php

namespace App\Console\Commands;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Events\RideRequestEvent;
use App\Events\RideAutoRejected;
use App\Events\NoDriverFound;
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
        try {
            $this->sendNotifications();
            sleep(20);
            $this->sendNotifications();
            sleep(20);
            $this->sendNotifications();

            $this->info('Ride requests have been dispatched to the queue.');
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }

    }

    private function sendNotifications()
    {
        \Log::info('send request to next running...', [Carbon::now()->toDateTimeString()]);
        // TODO: save seconds in config file
        $timeLimit = Carbon::now()->subSeconds(20);
        $rides = \App\Models\Ride::where('status', 'requested')
            ->where('created_at', '<', $timeLimit)
            ->get();

        foreach ($rides as $ride) {
            // every no of seconds defined in settings reject or accept will be called
            // if that is not called and this scheduled job runs then it can ovveride update status to rejected
            $responses = $ride->ride_responses()->where('ride_id', $ride->id)
            ->where('created_at', '<', $timeLimit)
            ->where('status','!=', DriverRideStatusEnum::AUTO_REJECTED)
            ->where('status','!=', DriverRideStatusEnum::REJECTED)
            ->get();

            foreach($responses as $ride_response) {
                $ride_response->update([
                    'status'=> DriverRideStatusEnum::AUTO_REJECTED
                ]);

                event(new RideAutoRejected($ride, $ride_response->driver_id));
            }

            $driver = DriverRepository::getNextAvailableDriver($ride);

            if ($driver) {
                $driver->ride_responses()->create([
                    'ride_id' => $ride->id,
                    'status' => DriverRideStatusEnum::PENDING,
                ]);

                event(new RideRequestEvent($ride, $driver, $ride->customer));
            }else{
                // TODO: save minutes in config file
                $requestExpiredTime = Carbon::now()->subMinutes(2);

                // and there is no ride request pending from driver side or driver request time not passed
                // check driver request status and time
                if(Carbon::parse($ride->created_at)->lessThanOrEqualTo($requestExpiredTime)) {
                    \Log::info('no driver found', [$ride->created_at, $requestExpiredTime]);

                    event(new NoDriverFound($ride));

                    $ride->status = StatusEnum::NO_DRIVER_FOUND;
                    $ride->stream_status = 'completed';
                    $ride->save();
                }
            }
        }
    }
}
