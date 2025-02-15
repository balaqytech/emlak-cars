<div class="hs-accordion bg-white border -mt-px first:rounded-t-lg last:rounded-b-lg" id="hs-heading-{{ $index }}">
    <button
        class="hs-accordion-toggle hs-accordion-active:text-primary px-6 py-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none"
        aria-expanded="false" aria-controls="hs-collapse-{{ $index }}">
        {{ $title }}
        <svg class="hs-accordion-active:hidden block size-4" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6"></path>
        </svg>
        <svg class="hs-accordion-active:block hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="m18 15-6-6-6 6"></path>
        </svg>
    </button>
    <div id="hs-collapse-{{ $index }}"
        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 px-6 py-3" role="region"
        aria-labelledby="hs-heading-{{ $index }}">
        <p class="text-gray-800 dark:text-neutral-200">
            {!! $slot !!}
        </p>
    </div>
</div>
