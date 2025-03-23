@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

    $calculator = FilamentFlatPage::get('calculator.json', 'activate');
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.calculator.page_title') }}
    </x-slot>

    @if ($calculator)
        <livewire:installment-calculator />
    @else
        <section>
            <div class="wrapper py-24">
                <div class="lg:col-span-2">
                    <livewire:cash-purchase-application-form method="installment" />
                </div>
            </div>
        </section>
    @endif

</x-page-layout>
