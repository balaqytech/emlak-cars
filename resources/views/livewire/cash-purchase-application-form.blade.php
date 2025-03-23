<div class="px-4 py-8">
    <form wire:submit.prevent="submit" class="grid sm:grid-cols-2 gap-4">

        <x-select name="vehicle_id" label="{{ __('frontend.calculator.vehicle') }}" wire:model.live="vehicle_id"
            :error="$errors->first('form.vehicle_id')">
            @foreach ($vehicles->pluck('name', 'id') as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </x-select>

        <x-select name="model" label="{{ __('frontend.calculator.vehicle_model') }}" wire:model.live="model_id"
            :error="$errors->first('model_id')">
            @if ($vehicleModels)
                @foreach ($vehicleModels->pluck('name', 'id') as $value => $label)
                    <option value="{{ $value }}" @if ($value == $model_id) selected @endif>
                        {{ $label }}</option>
                @endforeach
            @endif
        </x-select>
        <x-select wire:model="color" name="color" label="{{ __('frontend.cash_purchase_form.choose_color') }}"
            :error="$errors->first('color')">
            @if ($model)
                @foreach ($model->colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            @endif
        </x-select>
        <x-input label="{{ __('frontend.cash_purchase_form.name') }}" name="name" type="text" wire:model="name" />
        <x-input label="{{ __('frontend.cash_purchase_form.email') }}" name="email" type="email"
            wire:model="email" />
        <x-input label="{{ __('frontend.cash_purchase_form.phone') }}" name="phone" type="text"
            wire:model="phone" />
        <x-input label="{{ __('frontend.cash_purchase_form.city') }}" name="city" type="text"
            wire:model="city" />

        <x-select wire:model.live="purchase_type" name="purchase_type"
            label="{{ __('frontend.cash_purchase_form.purchase_type') }}" :error="$errors->first('purchase_type')">
            @foreach (\App\Enums\PurchaseType::cases() as $type)
                <option value="{{ $type->value }}">{{ $type->getLabel() }}</option>
            @endforeach
        </x-select>
        {{-- @if ($purchase_type == 'corporate')
            hello
        @endif --}}
        <div class="mb-4 col-span-full">
            <label
                class="block text-sm font-medium text-gray-700">{{ __('frontend.cash_purchase_form.contact_via') }}</label>
            <div class="flex flex-col md:flex-row gap-4 mt-2">
                @foreach (\App\Enums\ContactMethod::cases() as $method)
                    <x-checkbox :name="$method->value" :label="$method->getLabel()" :value="$method->value" wire:model="contact_methods" />
                @endforeach
            </div>
            @if ($errors->has('contact_methods'))
                <span class="text-red-500 text-sm">{{ $errors->first('contact_methods') }}</span>
            @endif
        </div>
        <div class="mt-4 grid">
            <x-submit-button>{{ __('frontend.contact.form.submit') }}</x-submit-button>
        </div>

    </form>
    <div x-data="{ successMessage: '' }" class="mt-4"
        @form-sent.window="successMessage = $event.detail.message;setTimeout(() => modalIsOpen = false, 3000)">
        <template x-if="successMessage">
            <div class="p-2 mb-4 text-green-700 bg-green-200 border border-green-400 rounded">
                <span x-text="successMessage"></span>
            </div>
        </template>
    </div>
</div>
