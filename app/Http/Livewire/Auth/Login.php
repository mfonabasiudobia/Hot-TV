<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use App\Events\TestEvent;

class Login extends BaseComponent
{

    public $user, $username, $password, $rm;

    public function mount(){
         if(request()->has('signature')){
            if (!request()->hasValidSignature()) {
                abort(401);
            }

            try {
                throw_unless(AuthRepository::verifyOtp([ 'email' => request('email') ]), "An error occured, please try again");

                toast()->success("Email has been verified")->pushOnNextPage();

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->pushOnNextPage();
            }

         }
    }

    public function submit(){

        event(new TestEvent($this->username, $this->password));
        return;

        try {
            if(AuthRepository::login([ 'username' => $this->username, 'password' => $this->password])){
                if(is_user_logged_in()){
                    return redirect()->route('home');
                }

                auth()->logout();
                toast()->danger('Invalid Login Credentials')->push();
            }else{
                toast()->danger('Invalid Login Credentials')->push();
            }
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }

    }

    public function resendVerificationMail(){
        try {
            throw_unless(AuthRepository::sendOtp(session('confirmation-email')), "Failed to send email");

            toast()->success('Email has been sent!')->push();

            session()->flash('confirmation-email-message', true);

            $this->dispatchBrowserEvent('trigger-email-sent');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
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
