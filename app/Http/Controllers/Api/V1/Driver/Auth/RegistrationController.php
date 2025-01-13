<?php

namespace App\Http\Controllers\Api\V1\Driver\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Auth\RegistrationRequest;
use App\Models\RideVehicle;
use App\Models\User;
use App\Models\VerificationDocument;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request)
    {
        try {
            $firstName = $request->input('first_name');
            $lastName = $request->input('last_name');
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');

            $user = AuthRepository::register([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'status' => StatusEnum::LOCKED->value,
            ]);

            if($request->filled('vehicle_reg_number')) {
                $regDetails = [
                    'driver_id' => $user->id,
                    'vehicle_reg_number' => $request->vehicle_reg_number,
                    'vehicle_make' => $request->make,
                    'vehicle_model' => $request->model,
                    'vehicle_year' => $request->year,
                    'vehicle_color' => $request->color,
                ];

                RideVehicle::create($regDetails);
            }

            $disk = env('FILESYSTEM_DISK');

            foreach($request->file("verification_docs") as $key => $file) {
                $uuid = Str::uuid();
                $filename = $uuid . "." . $file->getClientOriginalName();
                $path = $file->storeAs('verficationdocs/' . $user->id , $filename, $disk);

                VerificationDocument::create([
                    'user_id'=> $user->id,
                    'filename'=> $filename,
                    'path'=> $path,
                    'disk'=> $disk
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::REGISTRATION_PROCESS->value,
                'data' => [
                    'driver' => $user->load('verification_documents', 'vehicles')
                ]
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }
}
