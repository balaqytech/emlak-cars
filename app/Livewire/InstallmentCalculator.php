<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Livewire\Component;

class InstallmentCalculator extends Component
{
    public Bank $bank;
    public $selectedBank = null;
    public $selectedVehicle = null;
    public $vehicleModels = [];
    public $selectedModel = null;
    public $colors = [];
    public $price = 0;

    // الدفعة الأولى
    public $downPaymentPercentage = 0;
    public $downPayment = 0;

    public float $monthlyInstallment = 0;

    public function updatedSelectedVehicle($vehicleId)
    {
        $this->vehicleModels = VehicleModel::where('vehicle_id', $vehicleId)->get();
    }

    public function updatedSelectedModel($modelId)
    {
        $this->colors = VehicleModel::find($modelId)->colors;
    }

    public function updatedDownPaymentPercentage($percentage)
    {
        $this->downPayment = ($percentage / 100) * $this->price;
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
        $this->bank = Bank::find($this->selectedBank);
        $price = $this->price;

        $this->monthlyInstallment = $this->calculateMonthlyInstallment($this->bank, $price);
    }

    private function calculateMonthlyInstallment(Bank $bank, float $price): float
    {
        // الدفعة الأخيرة
        $lastPayment = $price * $bank->percentage / 100;

        // هامش الربح
        $profitMargin = ($price - $this->downPayment) * ($bank->benefits / 100) * $bank->period;

        // التأمين
        $insurance = $price * $bank->insurance / 100;

        $monthlyInstallment = (($price - $this->downPayment - $lastPayment) + $profitMargin + $insurance) / ($bank->period * 12);

        dump($lastPayment, $profitMargin, $insurance, $monthlyInstallment);

        return $monthlyInstallment;
    }
}
