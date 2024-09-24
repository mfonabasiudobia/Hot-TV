<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Repositories\ContactRepository;

class Contact extends BaseComponent
{

    public $subject, $first_name, $last_name, $email, $mobile_number, $message;

    public function submit(){

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'mobile_number' => 'required',
        ]);

        $data = [
            'email' => $this->email,
            'name' => "$this->first_name $this->last_name",
            'phone' => $this->mobile_number,
            'subject' => $this->subject,
            'content' => $this->message
        ];

        try {

            throw_unless(ContactRepository::create($data), "Failed to send message");

            toast()->success('Message has been sent!')->push();

            $this->reset();

        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();

        }

    }


    public function render()
    {
        return view('livewire.contact');
    }
}
