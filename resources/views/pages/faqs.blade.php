@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

    $grouped_faqs = collect(FilamentFlatPage::get('faqs.json', 'faqs'))->groupBy('group')->toArray();
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.faqs.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper">
            @foreach ($grouped_faqs as $name => $group)
                <div class="py-12 max-w-3xl mx-auto">
                    <h2 class="font-bold text-3xl text-primary text-center">{{ $name }}</h2>
                    <div class="mt-4 hs-accordion-group">
                        @foreach ($group as $faq)
                            <x-accordion :title="$faq['question']" index="{{ $loop->index }}">
                                <p>{!! str($faq['answer'])->sanitizeHtml() !!}</p>
                            </x-accordion>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-page-layout>
