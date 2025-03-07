<section>
    <div class="wrapper py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12" x-data
            x-on:scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
            <form class="flex flex-col gap-4" wire:submit.prevent="calculate">
                <h2 class="font-bold text-primary">{{ __('frontend.calculator.vehicle_details') }}</h2>
                <div id="car-details"
                    class="grid grid-cols-1 md:grid-cols-2 items-center gap-4 p-8 border border-slate-200 rounded-lg">
                    <x-select name="vehicle_id" label="{{ __('frontend.calculator.vehicle') }}"
                        wire:model.live="form.vehicle_id" :error="$errors->first('form.vehicle_id')">
                        @foreach ($vehicles->pluck('name', 'id') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select>
                    <x-select name="model" label="{{ __('frontend.calculator.vehicle_model') }}"
                        wire:model.live="form.model_id" :error="$errors->first('form.model_id')">
                        @if ($form->vehicleModels)
                            @foreach ($form->vehicleModels->pluck('name', 'id') as $value => $label)
                                <option value="{{ $value }}" @if ($value == $form->model_id) selected @endif>
                                    {{ $label }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    <x-select name="color" label="{{ __('frontend.calculator.color') }}"
                        wire:model.live="form.color_id" :error="$errors->first('form.color_id')">
                        @if ($form->colors)
                            @foreach ($form->colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    <x-select name="license_type" label="{{ __('frontend.calculator.license_type') }}"
                        wire:model.live="form.license_type" :error="$errors->first('form.license_type')">
                        @foreach (\Panakour\FilamentFlatPage\Facades\FilamentFlatPage::get('calculator.json', 'license_types') as $type)
                            <option value="{{ $type['amount'] }}">{{ $type['name'] }}</option>
                        @endforeach
                    </x-select>
                </div>

                <h2 class="font-bold text-primary">{{ __('frontend.calculator.installment_details') }}</h2>
                <div id="installment-details"
                    class="grid grid-cols-1 md:grid-cols-2 items-start gap-4 p-8 border border-slate-200 rounded-lg">
                    <x-select name="banks" label="{{ __('frontend.calculator.bank') }}" wire:model="form.bank"
                        :error="$errors->first('form.bank')">
                        @foreach ($banks->pluck('name', 'id') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select>
                    <x-numeric-input name="down_payment" label="{{ __('frontend.calculator.down_payment') }}"
                        wire:model="form.down_payment" :error="$errors->first('form.down_payment')" />
                </div>

                <h2 class="font-bold text-primary">{{ __('frontend.calculator.salary_details') }}</h2>
                <div id="installment-details"
                    class="grid grid-cols-1 md:grid-cols-2 items-start gap-4 p-8 border border-slate-200 rounded-lg">
                    <x-numeric-input name="salary" label="{{ __('frontend.calculator.salary') }}"
                        wire:model="form.salary" :error="$errors->first('form.salary')" />
                    <x-select name="license_type" label="{{ __('frontend.calculator.job_type') }}"
                        wire:model="form.job_type" :error="$errors->first('form.job_type')">
                        @foreach (\Panakour\FilamentFlatPage\Facades\FilamentFlatPage::get('calculator.json', 'job_types') as $type)
                            <option value="{{ $type['percentage'] }}">{{ $type['name'] }}</option>
                        @endforeach
                    </x-select>
                    <x-numeric-input name="obligations" label="{{ __('frontend.calculator.do_you_have_obligations') }}"
                        wire:model="form.obligations" :error="$errors->first('form.obligations')" />
                </div>

                <x-submit-button>
                    <x-spinner wire:loading wire:target="calculate" />
                    {{ __('frontend.calculator.calculate') }}
                </x-submit-button>
                <div style="font-size: 10px">Powered by <a class="text-primary underline" href="https://balaqytech.com"
                        target="_blank">Balaqytech</a></div>
            </form>

            @if ($monthlyInstallment > 0)
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-slate-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                                سعر
                                                السيارة</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                                {{ $price }} ريال سعودي</td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-slate-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                                الدفعة
                                                الأولى</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                                {{ $form->down_payment }}
                                                ريال سعودي</td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-slate-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                                القسط
                                                الشهري</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                                {{ $monthlyInstallment }} ريال سعودي</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($canApply)
                        <div class="px-4 py-8">
                            <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30"
                                role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                                <div class="flex">
                                    <div class="shrink-0">
                                        <span
                                            class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                            <x-icons.check class="shrink-0 size-4" />
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 id="hs-bordered-success-style-label"
                                            class="text-gray-800 font-semibold dark:text-white">
                                            {{ __('frontend.calculator.approved') }}
                                        </h3>
                                        <p class="text-sm text-gray-700 dark:text-neutral-400">
                                            {{ __('frontend.calculator.approved_message') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <form wire:submit.prevent="submit" class="grid sm:grid-cols-2 gap-4 mt-4">
                                <x-input label="{{ __('frontend.cash_purchase_form.name') }}" name="name"
                                    type="text" wire:model="name" />
                                <x-input label="{{ __('frontend.cash_purchase_form.email') }}" name="email"
                                    type="email" wire:model="email" />
                                <x-input label="{{ __('frontend.cash_purchase_form.phone') }}" name="phone"
                                    type="text" wire:model="phone" />
                                <x-input label="{{ __('frontend.cash_purchase_form.city') }}" name="city"
                                    type="text" wire:model="city" />
                                <div class="mb-4 col-span-full">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('frontend.cash_purchase_form.contact_via') }}</label>
                                    <div class="flex flex-col md:flex-row gap-4 mt-2">
                                        @foreach (\App\Enums\ContactMethod::cases() as $method)
                                            <x-checkbox :name="$method->value" :label="$method->getLabel()" :value="$method->value"
                                                wire:model="contact_methods" />
                                        @endforeach
                                    </div>
                                    @if ($errors->has('contact_methods'))
                                        <span
                                            class="text-red-500 text-sm">{{ $errors->first('contact_methods') }}</span>
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
                    @else
                        <div class="bg-red-50 border-s-4 border-red-500 p-4 mt-4" role="alert" tabindex="-1"
                            aria-labelledby="hs-bordered-red-style-label">
                            <div class="flex">
                                <div class="shrink-0">
                                    <!-- Icon -->
                                    <span
                                        class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800">
                                        <x-icons.x class="shrink-0 size-4" />
                                    </span>
                                    <!-- End Icon -->
                                </div>
                                <div class="ms-3">
                                    <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold">
                                        {{ __('frontend.calculator.declined') }}
                                    </h3>
                                    <p class="text-sm text-gray-700">
                                        {{ __('frontend.calculator.declined_message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div> @endif
                                </div>
                            </div>
</section>
