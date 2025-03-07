<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Bank;
use App\Models\VehicleModel;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class CalculatorForm extends Form
{
    #[Rule(['required', 'exists:vehicles,id'])]
    public $vehicle_id;

    public $vehicleModels = [];

    #[Rule(['required', 'exists:vehicle_models,id'])]
    public $model_id;

    public $colors = [];

    #[Rule(['required', 'exists:colors,id'])]
    public $color_id;

    #[Rule(['required', 'string', 'max:255'])]
    public $license_type;

    #[Rule(['required', 'exists:banks,id'])]
    public $bank;

    #[Rule(['required', 'numeric', 'min:0'])]
    public $down_payment;

    #[Rule(['required', 'numeric', 'min:1', 'max:100000'])]
    public $salary;

    #[Rule(['required', 'string', 'max:255'])]
    public $job_type;

    #[Rule(['required', 'numeric', 'min:0'])]
    public $obligations = 0;
}
