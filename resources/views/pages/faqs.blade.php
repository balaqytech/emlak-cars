@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

    $grouped_faqs = collect(FilamentFlatPage::get('faqs.json', 'faqs'))->groupBy('group')->toArray();
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.faqs.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper py-24">
            @foreach ($grouped_faqs as $name => $group)
                <div class="grid md:grid-cols-5 gap-10">
                    <div class="md:col-span-2">
                        <div class="max-w-xs">
                            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-slate-800">{{ $name }}</h2>
                        </div>
                    </div>
                    <div class="md:col-span-3">
                        <div class="mt-4 hs-accordion-group">
                            @foreach ($group as $faq)
                                <x-accordion :title="$faq['question']">
                                    <p>{!! str($faq['answer'])->sanitizeHtml() !!}</p>
                                </x-accordion>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr class="mt-10 border-t border-gray-200">
            @endforeach
        </div>
    </section>
</x-page-layout>
