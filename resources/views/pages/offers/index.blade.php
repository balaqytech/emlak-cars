@php
    use function Laravel\Folio\name;

    name('offers.index');

    $offers = \App\Models\Offer::paginate(9);
@endphp

<x-page-layout>
    <x-slot name="title">
       {{ __('frontend.offers') }}
    </x-slot>

    <section class="py-20">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($offers as $offer)
                    @if ($loop->first)
                        <x-offer-card :offer="$offer" class="col-span-2" />
                    @else
                        <x-offer-card :offer="$offer" />
                    @endif
                @empty
                    <p>{{ __('frontend.no_offers') }}</p>
                @endforelse
            </div>
            <div class="mt-10">
                {{ $offers->links() }}
            </div>
        </div>
    </section>
</x-page-layout>