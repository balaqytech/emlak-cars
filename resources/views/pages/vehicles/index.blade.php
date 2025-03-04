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
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse ($vehicles as $vehicle)
                    <x-vehicle-card :vehicle="$vehicle" />
                @empty
                    <div class="mt-8 col-span-3">
                        <x-icons.question class="block mx-auto size-24 text-primary" />
                        <p class="text-center">{{ __('frontend.vehicles.no_vehicles') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-10">
                {{ $vehicles->links() }}
            </div>
        </div>
    </section>

</x-page-layout>
