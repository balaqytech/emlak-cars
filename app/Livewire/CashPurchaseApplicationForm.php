<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Vehicle;
use Livewire\Component;
use App\Models\VehicleModel;
use Livewire\Attributes\Rule;
use App\Models\PurchaseApplication;

class CashPurchaseApplicationForm extends Component
{
    #[Rule(['required', 'exists:vehicles,id'])]
    public $vehicle_id;

    public $vehicleModels = [];

    #[Rule(['required', 'exists:vehicle_models,id'])]
    public $model_id;

    public $model;

    #[Rule(['required', 'exists:colors,id'])]
    public string $color;

    #[Rule(['required', 'string', 'max:255'])]
    public string $name;

    #[Rule(['required', 'email', 'max:255'])]
    public string $email;

    #[Rule(['required', 'string', 'max:15'])]
    public string $phone;

    #[Rule(['required', 'string', 'max:50'])]
    public string $city;

    #[Rule(['required', 'string', 'max:50'])]
    public string $purchase_type;

    #[Rule(['required', 'string', 'max:50'])]
    public string $company_name;

    #[Rule(['required', 'string', 'max:50'])]
    public string $commercial_registration;

    #[Rule(['required', 'string', 'max:50'])]
    public string $company_phone;

    #[Rule(['required', 'array'])]
    public array $contact_methods;

    public function mount()
    {
        if (request()->query('model')) {
            $this->model = VehicleModel::find(request()->query('model'));
            $this->model_id = $this->model->id;
            $this->vehicle_id = $this->model->vehicle->id;
            $this->vehicleModels = $this->model->vehicle->vehicleModels;
        }
    }

    public function submit()
    {
        $this->validate();

        $fields =[
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'contact_via' => $this->contact_methods,
            'purchase_type' => $this->purchase_type,
        ];

        if($fields['purchase_type'] == 'corporate'){
            $fields['company_name'] = $this->company_name;
            $fields['commercial_registration'] = $this->commercial_registration;
            $fields['company_phone'] = $this->company_phone;
        }

        PurchaseApplication::create([
            'payment_method' => 'cash',
            'fields' => $fields,
            'vehicle_details' => Color::find($this->color)->toArray(),
        ]);

        $this->reset('name', 'email', 'phone', 'contact_methods');

        $this->dispatch('form-sent', message: __('frontend.cash_purchase_form.form_successfully_sent'));
    }

    public function render()
    {
        return view('livewire.cash-purchase-application-form', [
            'vehicles' => Vehicle::all(),
        ]);
    }
}
