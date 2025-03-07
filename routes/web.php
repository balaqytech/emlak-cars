<?php

use App\Livewire\InstallmentCalculator;
use Illuminate\Support\Facades\Route;

Route::get('/installment-calculator', InstallmentCalculator::class)->name('installment-calculator');