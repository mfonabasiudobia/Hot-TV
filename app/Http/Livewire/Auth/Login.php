<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;

class Login extends BaseComponent
{

    public $username, $password, $rm;

    public function submit(){

        if(AuthRepository::login([ 'username' => $this->username, 'password' => $this->password])){
            redirect()->route('user.dashboard');
        }else{
            toast()->danger('Invalid Login Credentials')->push();
        }

    }

    public function logout(){
        auth()->logout();
        if(!auth()->check()) return redirect()->route('login');
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
