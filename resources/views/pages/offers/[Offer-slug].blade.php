@php
    use function Laravel\Folio\name;

    name('offers.show');
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ $offer->title }}
    </x-slot>

    <section class="wrapper">
        <div class="max-w-5xl mx-auto">
            <img loading="lazy" src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}"
            class="object-cover object-center w-full h-full">
        </div>
    </section>

    <article class="max-w-4xl mx-auto p-6">
        <header
            class="flex flex-col items-center justify-center gap-4 mb-24 -mt-8 md:-mt-24 relative bg-white p-8 lg:p-20 text-center shadow-3xl rounded-lg">
            <x-breadcrumb :items="[['label' => __('frontend.navigation.offers'), 'url' => localizedUrl('/offers/')],['label' => $offer->title]]" color="slate-400" />
            <h1 class="text-3xl font-bold text-slate-800">{{ $offer->title }}</h1>
            <div class="text-sm mt-2">
                <p class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white ">{{ __('frontend.offers.due_date') }} <time
                        datetime="{{ $offer->due_date }}">{{ $offer->due_date->format('d/m/Y') }}</time></p>
            </div>
        </header>

        <section class="prose max-w-none">
            {!! str($offer->content)->sanitizeHtml() !!}
        </section>
    </article>

    @if ($offer->faqs)
        <section class="py-20 bg-slate-50 mb-8">
            <div class="container max-w-6xl">
                <h2 class="text-3xl font-bold text-slate-800 text-center mb-8">{{ __('frontend.offers.faqs') }}</h2>
                <div
                    class="hs-accordion-group">
                    @foreach ($offer->faqs as $faq)
                        <x-accordion :title="$faq['question']" index="{{ $loop->index }}">
                            <p>{!! str($faq['answer'])->sanitizeHtml() !!}</p>
                        </x-accordion>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-app-layout>
