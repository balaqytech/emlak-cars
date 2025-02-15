@php
    use function Laravel\Folio\name;

    name('offers.show');
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ $offer->title }}
    </x-slot>

    <section class="">
        <div class="wrapper">
            <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}"
            class="">
        </div>
    </section>

    <article class="max-w-4xl mx-auto p-6">
        <header
            class="flex flex-col items-center justify-center gap-4 mb-24 -mt-36 relative bg-white p-20 text-center shadow-3xl rounded-lg">
            <h1 class="text-5xl font-bold text-slate-800">{{ $offer->title }}</h1>
            <div class="text-sm mt-2">
                <p>{{ __('frontend.due_date') }} <time
                        datetime="{{ $offer->due_date }}">{{ $offer->due_date->format('d/m/Y') }}</time></p>
            </div>
        </header>

        <section class="prose max-w-none">
            {!! str($offer->content)->sanitizeHtml() !!}
        </section>
    </article>

    @if ($offer->faqs)
        <section class="py-20 bg-slate-50">
            <div class="container max-w-6xl">
                <h2 class="text-3xl font-bold text-slate-800 text-center mb-8">{{ __('frontend.faqs') }}</h2>
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
