<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.calculator.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper py-24">
            @livewire('installment-calculator')
        </div>
    </section>
</x-page-layout>