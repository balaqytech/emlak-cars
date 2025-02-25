@php
    use function Laravel\Folio\name;

    name('offers.index');

    $offers = \App\Models\Offer::paginate(9);
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.offers.page_title') }}
    </x-slot>

    <x-slot name="excerpt">
        {{ __('frontend.offers.subheading') }}
    </x-slot>

    <section class="py-20">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($offers as $offer)
                    <x-offer-card :offer="$offer" />
                @empty
                    <div class="mt-8">
                        <x-icons.question class="block mx-auto size-24 text-primary" />
                        <p class="text-center">{{ __('frontend.offers.no_offers') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-10">
                {{ $offers->links() }}
            </div>
        </div>
    </section>
</x-page-layout>
