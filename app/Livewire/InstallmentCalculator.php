<?php

namespace App\Livewire;

use App\Enums\PurchaseMethod;
use App\Models\Bank;
use App\Models\Vehicle;
use Livewire\Component;
use App\Models\VehicleModel;
use Livewire\Attributes\Rule;
use App\Models\PurchaseApplication;
use App\Livewire\Forms\CalculatorForm;
use App\Models\Color;

class InstallmentCalculator extends Component
{
    public CalculatorForm $form;

    public Bank $bank;
    public float $price;
    public float $monthlyInstallment;
    public bool $canApply = false;

    //form fields
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

    public function mount()
    {
        $model = VehicleModel::find(request()->query('model'));
        $this->form->model_id = $model?->id;
        $this->form->vehicleModels = $model?->vehicle->vehicleModels;
        $this->form->colors = $model?->colors;
        $this->form->vehicle_id = $model?->vehicle->id;
    }

    public function updatedFormVehicleId($vehicle_id)
    {
        $this->form->vehicleModels = VehicleModel::where('vehicle_id', $vehicle_id)->get();
    }

    public function updatedFormModelId($modelId)
    {
        $this->form->colors = VehicleModel::find($modelId)->colors;
    }

    public function render()
    {
        return view('livewire.installment-calculator', [
            'banks' => Bank::all(),
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function calculate()
    {
        $this->form->validate();
        $this->bank = Bank::find($this->form->bank);
        $this->price = Color::find($this->form->color_id)->installment_price;

        $this->monthlyInstallment = $this->calculateMonthlyInstallment($this->bank, $this->price);
        $this->canApply = $this->calculateCanApply();

        $this->dispatch('scroll-to-top');
    }

    private function calculateMonthlyInstallment(Bank $bank, float $price): float
    {
        // الدفعة الأخيرة
        $lastPayment = $price * $bank->percentage / 100;

        // هامش الربح
        $profitMargin = ($price - $this->form->down_payment) * ($bank->benefits / 100) * $bank->period;

        // التأمين
        $insurance = $price * $bank->insurance / 100 * $bank->period;

        $monthlyInstallment = (($price - $this->form->down_payment - $lastPayment) + $profitMargin + $insurance) / ($bank->period * 12);

        return $monthlyInstallment;
    }

    private function calculateCanApply(): bool
    {
        $salary = $this->form->salary;
        $jobType = $this->form->job_type;
        $obligations = $this->form->obligations;

        $installment = $this->monthlyInstallment;
        $availableSalary = $salary - $obligations - ($salary * $jobType / 100);

        return $availableSalary >= $installment;
    }

    public function submit()
    {
        $this->validate();

        PurchaseApplication::create([
            'payment_method' => PurchaseMethod::Installment,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'contact_via' => $this->contact_methods,
            'vehicle_details' => Color::find($this->form->color_id)->toArray(),
            'installment_details' => [
                'bank' => $this->bank->name,
                'down_payment' => $this->form->down_payment,
                'monthly_installment' => $this->monthlyInstallment,
                'salary' => $this->form->salary,
                'job_type' => $this->form->job_type,
                'obligations' => $this->form->obligations,
                'license_type' => $this->form->license_type,
            ],
        ]);

        $this->dispatch('form-sent', message: __('frontend.cash_purchase_form.form_successfully_sent'));
    }
}
