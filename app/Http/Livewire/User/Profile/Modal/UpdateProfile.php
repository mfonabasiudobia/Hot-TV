<?php

namespace App\Http\Livewire\User\Profile\Modal;

use App\Http\Livewire\BaseComponent;
use App\Repositories\MemberRepository;

class UpdateProfile extends BaseComponent
{

    public $first_name, $last_name, $email, $password, $password_confirmation;

    public function mount(){
        $this->fill([
            'first_name' => user()->first_name,
            'last_name' => user()->last_name,
            'email' => user()->email
        ]);
    }

    public function submit(){

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . auth()->id(),
            'password' => 'nullable|confirmed|min:6|alpha_num'
        ]);


        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        ];

        try {

            throw_unless(MemberRepository::updateProfile($data, auth()->id()), "Failed to update account");

            toast()->success('Account Information has been updated')->push();

            $this->dispatchBrowserEvent('trigger-close-modal');

        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();

        }

    }


    public function render()
    {
        return view('livewire.user.profile.modal.update-profile');
    }
}
