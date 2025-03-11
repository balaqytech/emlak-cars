<?php

namespace App\Livewire;

use App\Models\Color;
use Livewire\Component;
use App\Models\VehicleModel;
use Livewire\Attributes\Rule;
use App\Models\PurchaseApplication;

class CashPurchaseApplicationForm extends Component
{
    public $model;
    public $payment_method;

    #[Rule(['required', 'exists:colors,id'])]
    public string $color;

    #[Rule(['required', 'string', 'max:255'])]
    public string $name;

    #[Rule(['required', 'email', 'max:255'])]
    public string $email;

    #[Rule(['required', 'string', 'max:255'])]
    public string $phone;

    #[Rule(['required', 'string', 'max:255'])]
    public string $city;

    #[Rule(['required', 'array'])]
    public array $contact_methods;

    public function mount($model, $paymentMethod)
    {
        $this->model = VehicleModel::find($model);
        $this->payment_method = $paymentMethod;
    }

    public function submit()
    {
        $this->validate();

        PurchaseApplication::create([
            'payment_method' => $this->payment_method,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'contact_via' => $this->contact_methods,
            'vehicle_details' => Color::find($this->color)->toArray(),
        ]);

        $this->reset('name', 'email', 'phone', 'contact_methods');

        $this->dispatch('form-sent', message: __('frontend.cash_purchase_form.form_successfully_sent'));
    }

    public function render()
    {
        return view('livewire.cash-purchase-application-form');
    }
}
