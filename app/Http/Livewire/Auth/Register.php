<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;

class Register extends BaseComponent
{

    public $username, $first_name, $last_name, $email, $password, $password_confirmation;

    public function submit(){

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6|alpha_num'
        ]);


        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        ];

        try {

            throw_unless(AuthRepository::register($data), "Failed to create user");

            toast()->success('User has been created')->pushOnNextPage();

            return redirect()->route("login");

        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();

        }

    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
