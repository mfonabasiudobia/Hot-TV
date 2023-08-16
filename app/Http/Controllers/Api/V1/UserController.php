<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MemberRepository;

class UserController extends Controller
{

    public function getProfile(){
        return $this->success("User profile", MemberRepository::getMemberById(auth()->id()));
    }

    public function updateUser(Request $request)
    {

         $validator = validator()->make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|unique:members,email',
            // 'username' => 'required|unique:members,username',
            'password' => 'nullable|min:6'
         ]);

         if($validator->fails()) return $this->fail($validator->errors()->first());


        try{
            throw_unless($user = MemberRepository::updateMember($request->all(), auth()->id()), "Failed to update User");

            return $this->success("Profile Updated", $user);
        }catch (\Exception $e) {
            return $this->fail($e->getMessage());                
        }   
    }

    public function deleteAccount()
    {
        return $this->success("Account has been deleted", MemberRepository::deleteAccount(auth()->id()));
    }
}
