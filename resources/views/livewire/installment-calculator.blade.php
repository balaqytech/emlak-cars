<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <form class="grid grid-cols-1 md:grid-cols-2 items-center gap-4" wire:submit.prevent="calculate">
        <x-select name="banks" label="{{ __('frontend.calculator.banks') }}" wire:model="selectedBank" :error="$errors->first('bank')">
            @foreach ($banks->pluck('name', 'id') as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </x-select>
        <x-select name="vehicles" label="{{ __('frontend.calculator.vehicles') }}" wire:model.live="selectedVehicle"
            :error="$errors->first('vehicles')">
            @foreach ($vehicles->pluck('name', 'id') as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </x-select>
        <x-select name="model" label="{{ __('frontend.calculator.vehicle_models') }}" wire:model.live="selectedModel"
            :error="$errors->first('selectedModel')" wire:loading.attr="disabled">
            @if ($vehicleModels)
                @foreach ($vehicleModels->pluck('name', 'id') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            @endif
        </x-select>
        <x-select name="color" label="{{ __('frontend.calculator.colors') }}" wire:model.live="price"
            :error="$errors->first('price')">
            @if ($colors)
                @foreach ($colors as $color)
                    <option value="{{ $color['installment_price'] }}">{{ $color['name'] }}</option>
                @endforeach
            @endif
        </x-select>
        <div class="max-w-sm space-y-3">
            <div>
                <label for="hs-trailing-icon" class="block text-sm font-medium mb-2">الدفعة الأولى</label>
                <div class="relative">
                    <input type="number" id="hs-trailing-icon" name="hs-trailing-icon"
                        wire:model.live="downPaymentPercentage"
                        class="py-3 px-4 ps-11 block w-full border border-slate-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="15">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">%</div>
                </div>
                <p>{{ $downPayment }}</p>
            </div>
        </div>
        <button type="submit"
            class="col-span-2 text-center py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
            Calculate
        </button>
    </form>

    @if ($monthlyInstallment > 0)
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <tbody>
                                <tr class="odd:bg-white even:bg-slate-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">سعر السيارة</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800" colspan="2">{{ $price }} SAR</td>
                                </tr>
                                <tr class="odd:bg-white even:bg-slate-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">الدفعة الأولى</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800" >{{ $downPaymentPercentage }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800" >{{ $downPayment }} SAR</td>
                                </tr>
                                <tr class="odd:bg-white even:bg-slate-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">القسط الشهري</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800" colspan="2">{{ $monthlyInstallment }} SAR</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
