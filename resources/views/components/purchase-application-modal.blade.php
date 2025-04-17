@php
    $model = $attributes->get('model');
@endphp

<div x-data="{ modalIsOpen: false }" class="w-full flex justify-center items-center">
    <x-outline-button x-on:click="modalIsOpen = true" type="button"
        class="whitespace-nowrap w-full cursor-pointer rounded-radius border border-primary dark:border-primary-dark bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">{{ __('frontend.vehicles.purchase') }}</x-outline-button>
    <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
        x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false"
        class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
        <!-- Modal Dialog -->
        <div x-show="modalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
            class="flex max-w-lg flex-col gap-4 bg-white overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <!-- Dialog Header -->
            <div
                class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                <h3 id="defaultModalTitle"
                    class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('frontend.vehicles.purchase') }}</h3>
                <button x-on:click="modalIsOpen = false" aria-label="close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
                        fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Dialog Body -->
            <div class="px-4 py-8">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <x-primary-button href="{{ localizedUrl('/cash-purchase-form?model=' . $model) }}"
                        class="cursor-pointer">{{ __('frontend.vehicles.cash_purchase_apply') }}</x-primary-button>
                    <x-primary-button
                        href="{{ localizedUrl('/installment-calculator?model=' . $model) }}">{{ __('frontend.vehicles.installment_apply') }}</x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
