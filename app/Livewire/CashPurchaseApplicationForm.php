<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Vehicle;
use Livewire\Component;
use App\Models\VehicleModel;
use Livewire\Attributes\Rule;
use App\Models\PurchaseApplication;
use Livewire\WithFileUploads;

class CashPurchaseApplicationForm extends Component
{
    use WithFileUploads;

    public string $payment_method;

    #[Rule(['required', 'exists:vehicles,id'])]
    public $vehicle_id;

    public $vehicleModels = [];

    #[Rule(['required', 'exists:vehicle_models,id'])]
    public $model_id;

    public $model;

    #[Rule(['required', 'exists:colors,id'])]
    public string $color;

    public $colors = [];

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

    #[Rule(['nullable', 'sometimes', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'])]
    public $identity;

    #[Rule(['nullable', 'sometimes', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'])]
    public $driving_license;

    public function mount($method)
    {
        $this->payment_method = $method;
        if (request()->query('model')) {
            $this->model = VehicleModel::find(request()->query('model'));
            $this->model_id = $this->model->id;
            $this->vehicle_id = $this->model->vehicle->id;
            $this->vehicleModels = $this->model->vehicle->vehicleModels;
        }
    }

    public function updatedVehicleId($vehicle_id)
    {
        $this->vehicleModels = VehicleModel::where('vehicle_id', $vehicle_id)->get();
    }

    public function updatedModelId($model_id)
    {
        $this->colors = VehicleModel::find($model_id)->colors;
    }

    public function submit()
    {
        // $this->validate();

        $fields = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'contact_via' => $this->contact_methods,
            'purchase_type' => $this->purchase_type,
        ];

        $attachments = [];

        if ($this->identity) {
            $attachments['identity'] = $this->identity->store('purchase-application', 'public');
        }

        if ($this->driving_license) {
            $attachments['driving_license'] = $this->driving_license->store('purchase-application', 'public');
        }

        if ($fields['purchase_type'] == 'corporate') {
            $fields['company_name'] = $this->company_name;
            $fields['commercial_registration'] = $this->commercial_registration;
            $fields['company_phone'] = $this->company_phone;
        }

        PurchaseApplication::create([
            'payment_method' => $this->payment_method,
            'fields' => $fields,
            'attachments' => $attachments,
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
