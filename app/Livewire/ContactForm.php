<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

class ContactForm extends Component
{
    #[Rule(['required', 'string', 'max:255'])]
    public string $name;

    #[Rule(['required', 'email', 'max:255'])]
    public string $email;

    #[Rule(['required', 'string', 'max:255'])]
    public string $phone;

    #[Rule(['required', 'string'])]
    public string $message;

    public $to;

    public function __construct()
    {
        $this->to = FilamentFlatPage::get('contact.json', 'contact_form_email');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }

    public function submit()
    {
        $this->validate();

        ContactSubmission::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);
        
        $this->reset();

        $this->dispatch('form-sent', message:  __('frontend.contact.form.notice') );
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
