<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.cash_purchase_form.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <livewire:cash-purchase-application-form />
                </div>
            </div>
        </div>
    </section>
</x-page-layout>

