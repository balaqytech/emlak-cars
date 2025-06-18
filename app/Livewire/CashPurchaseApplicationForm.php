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
    public $vehicle_id;

    public $vehicleModels = [];
    public $model_id;

    public $model;
    public string $color;

    public $colors = [];
    public string $name;
    public string $email;
    public string $phone;
    public string $city;
    public string $purchase_type;

    public string $company_name = '';

    public string $commercial_registration = '';

    public string $company_phone = '';
    public array $contact_methods;
    public $identity;
    public $driving_license;

    public function mount($method)
    {
        $this->payment_method = $method;
        if (request()->query('model')) {
            $this->model = VehicleModel::find(request()->query('model'));
            $this->model_id = $this->model->id;
            $this->vehicle_id = $this->model->vehicle->id;
            $this->vehicleModels = $this->model->vehicle->vehicleModels;
            $this->colors = $this->model->availableColors;
        }
    }

    public function updatedVehicleId($vehicle_id)
    {
        $this->vehicleModels = VehicleModel::where('vehicle_id', $vehicle_id)->get();
    }

    public function updatedModelId($model_id)
    {
        $this->colors = VehicleModel::find($model_id)->availableColors;
    }

    public function submit()
    {
        $this->validate();

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

        $this->reset();

        $this->dispatch('form-sent', message: __('frontend.cash_purchase_form.form_successfully_sent'));
    }

    public function rules()
    {
        return [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'model_id' => ['required', 'exists:vehicle_models,id'],
            'color' => ['required', 'exists:colors,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'city' => ['required', 'string', 'max:50'],
            'purchase_type' => ['required', 'string', 'max:50'],
            'company_name' => ['required_if:purchase_type,corporate', 'string', 'max:50'],
            'commercial_registration' => ['required_if:purchase_type,corporate', 'string', 'max:50'],
            'company_phone' => ['required_if:purchase_type,corporate', 'string', 'max:50'],
            'contact_methods' => ['required', 'array'],
            'identity' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'driving_license' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function render()
    {
        return view('livewire.cash-purchase-application-form', [
            'vehicles' => Vehicle::all(),
        ]);
    }
}
