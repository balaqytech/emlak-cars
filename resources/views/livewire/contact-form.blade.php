<div>
    <form wire:submit.prevent="submit" class="grid gap-4">
        <x-input label="{{ __('frontend.contact.form.name') }}" name="name" type="text" wire:model="name" />
        <x-input label="{{ __('frontend.contact.form.email') }}" name="email" type="email" wire:model="email" />
        <x-input label="{{ __('frontend.contact.form.phone') }}" name="phone" type="text" wire:model="phone" />
        <x-textarea label="{{ __('frontend.contact.form.message') }}" name="message" wire:model="message" />
        <div class="mt-4 grid">
            <x-submit-button>{{ __('frontend.contact.form.submit') }}</x-submit-button>
        </div>

        <div x-data="{ successMessage: '' }" @form-sent.window="successMessage = $event.detail.message; setTimeout(() => successMessage = '', 3000)">
            <template x-if="successMessage">
                <div class="p-2 mb-4 text-green-700 bg-green-200 border border-green-400 rounded">
                    <span x-text="successMessage"></span>
                </div>
            </template>
        </div>
    </form>
</div>
