<article {{ $attributes->merge(['class' => 'group flex flex-col bg-white shadow-3xl rounded-lg border border-slate-200 overflow-hidden transition-all duration-500']) }}>
    <a href="{{ localizedUrl('/offers/' . $offer->slug) }}" class="relative overflow-hidden h-80">
        <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}"
            class="w-full h-full object-cover object-center hover:scale-110  transition-all duration-500">
    </a>
    <div class="p-10 flex flex-col gap-2 bg-white">
        <h3 class="text-xl font-bold text-slate-700">
            <a href="{{ localizedUrl('/offers/' . $offer->slug) }}" class="hover:underline hover:text-primary">{{ $offer->title }}</a>
        </h3>
        <p class="mt-2 text-gray-800">
            {{  $offer->excerpt ?? strip_tags(str($offer->content)->words(15)) }}</p>
    </div>
    
    <hr>
    
    <div class="relative flex flex-col gap-2 px-10 py-4">
        <div class="relative overflow-hidden">
            <p class="text-gray-600 text-sm flex items-center gap-2 group-hover:-translate-y-8 transition-all duration-500">
                <x-icons.calendar class="w-4 h-4 inline-block text-primary"></x-icons.calendar>
                <time
                    datetime="{{ $offer->due_date }}">{{ __('frontend.offers.due_date_left', ['date' => $offer->due_date->diffForHumans()]) }}</time>
            </p>
            <a href="{{ localizedUrl('/offers/' . $offer->slug) }}" class="hover:underline block absolute start-0 top-0 translate-y-8 group-hover:translate-y-0 transition-all duration-500">{{ __('frontend.offers.read_more') }}</a>
        </div>
        <a href="{{ localizedUrl('/offers/' . $offer->slug) }}"
            class="bg-slate-700 text-white absolute  hover:underline w-10 h-10 rounded-full flex items-center justify-center end-10 -top-5">
            <x-icons.arrow-right class="w-4 h-4 inline-block text-white"></x-icons.arrow-right>
        </a>
    </div>
</article>
