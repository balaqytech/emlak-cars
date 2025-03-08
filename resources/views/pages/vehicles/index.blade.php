@php
    $vehicles = \App\Models\Vehicle::latest()->paginate(9);
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.vehicles.page_title') }}
    </x-slot>

    <x-slot name="excerpt">
        {{ __('frontend.vehicles.excerpt') }}
    </x-slot>

    <section class="py-24">
        <livewire:vehicle-search />
    </section>

</x-page-layout>
