<div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-on:keydown.esc.window="modalIsOpen = false"
    x-on:click.self="modalIsOpen = false"
    class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
    role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
    <!-- Modal Dialog -->
    <div x-show="modalIsOpen"
        x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        class="flex max-w-3xl w-full flex-col gap-4 overflow-hidden rounded-xl border border-outline bg-white text-on-surface ">
        <!-- Dialog Header -->
        <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4">
            <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong">
                {{ __('frontend.vehicles.cash_purchase_apply') }}</h3>
            <button x-on:click="modalIsOpen = false" aria-label="close modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                    fill="none" stroke-width="1.4" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Dialog Body -->
        <div class="px-4 py-8">
            <form wire:submit.prevent="submit" class="grid sm:grid-cols-2 gap-4">
                <x-select wire:model="color" name="color" label="{{ __('frontend.cash_purchase_form.choose_color') }}"
                    :error="$errors->first('color')">
                    @foreach ($model->colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </x-select>
                <x-input label="{{ __('frontend.cash_purchase_form.name') }}" name="name" type="text"
                    wire:model="name" />
                <x-input label="{{ __('frontend.cash_purchase_form.email') }}" name="email" type="email"
                    wire:model="email" />
                <x-input label="{{ __('frontend.cash_purchase_form.phone') }}" name="phone" type="text"
                    wire:model="phone" />
                <x-input label="{{ __('frontend.cash_purchase_form.city') }}" name="city" type="text"
                    wire:model="city" />
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
    </div>
</div>
