<?php

namespace App\Http\Controllers\Api\V1\Customer\User;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\User\UpdateProfileRequest;
use App\Http\Resources\Api\V1\Customer\Auth\AuthUserResource;
use Illuminate\Support\Facades\Auth;
use Botble\Media\Models\MediaFile;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $updating = false;

        if($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
            $updating = true;
        }

        if($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
            $updating = true;
        }

        if($request->has('email')) {
            $user->email = $request->input('email');
            $updating = true;
        }

        // dd($request->has('avatar'));
        if($request->has('avatar')){
            $avatar = $request->avatar;
            $avatarPath = "users";

            $profileAvatar = upload_avatar($avatar, $avatarPath);

            $media = MediaFile::create([
                'user_id' => $user->id,
                'name' => $profileAvatar,
                'alt'  => $profileAvatar,
                'folder_id' => 7,
                'mime_type' => $avatar->getMimetype(),
                'size' => $avatar->getSize(),
                'url' => $profileAvatar,
                'type' => 'internal'
            ]);

            $user->avatar_id = $media->id;
            $updating = true;
        }

        if($updating) {
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PROFILE_UPDATED->value,
            'data' => [
                'user' => new AuthUserResource($user)
            ]
        ]);
    }
}

