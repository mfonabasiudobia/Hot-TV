<?php

namespace App\Http\Livewire\Home\Partials;

use App\Http\Livewire\BaseComponent;
use Botble\Newsletter\Repositories\Eloquent\NewsletterRepository;
use Botble\Newsletter\Models\Newsletter as NewsletterModel;


class Newsletter extends BaseComponent
{
    private $newsletterRepo;

    public $name, $email;

    public function mount(){
        $this->newsletterRepo = new NewsletterRepository(new NewsletterModel);
    }

    public function submit(){
        
        $this->validate([
            'email' => 'required|email|unique:newsletters,email'
        ],[
            'email.unique' => 'You have already subscribed to our newsletter'
        ]);
        

        try {
            $data = ['email' => $this->email];

            throw_unless(NewsletterModel::create($data), "An error occured, Please try again");

            toast()->success('You have subscribed to our newsletter')->push();

            $this->reset();

        } catch (\Throwable $e) {
            return toast()->danger($e->getMessage())->push();
        }


    }



    public function render()
    {
        return view('livewire.home.partials.newsletter');
    }
}
