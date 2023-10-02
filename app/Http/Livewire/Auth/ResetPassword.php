<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use Illuminate\Validation\Rules\Password;

class ResetPassword extends BaseComponent
{

    public $email, $password, $uncompromisedEmail;


    public function mount(){

         if (!request()->hasValidSignature()) {
            abort(401);
         }

         $this->fill([
            'email' => request('email'),
            'uncompromisedEmail' => request('email')
         ]);

    }

    public function submit(){
        $this->validate([
            // 'password' => [ 'required', Password::min(8)->mixedCase()->letters()->uncompromised() ],
            'password' => 'required|min:6|alpha_num'
        ]);

        try {

            $data = [
                'email' => $this->uncompromisedEmail, 
                'password' => $this->password
            ];

            throw_unless($user = AuthRepository::resetPassword($data), "Sorry we could
            not update your password. Please
            try again.");

            toast()->success("Your Password has been updated")->push();

            return redirect()->route('login');

        } catch (\Throwable $e) {
             toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
