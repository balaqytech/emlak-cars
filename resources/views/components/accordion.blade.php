@props(['title'])

<div class="hs-accordion bg-white border -mt-px first:rounded-t-lg last:rounded-b-lg" id="hs-heading-{{ Str::slug($title) }}">
    <button
        class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 focus:outline-none focus:text-gray-500 rounded-lg"
        aria-expanded="false" aria-controls="hs-collapse-{{ Str::slug($title) }}">
        <x-icons.plus class="hs-accordion-active:hidden block size-3.5" />
        <x-icons.minus class="hs-accordion-active:block hidden size-3.5" />
        {{ $title }}
    </button>
    <div id="hs-collapse-{{ Str::slug($title) }}"
        class="hs-accordion-content hidden overflow-hidden transition-[height] duration-300" role="region"
        aria-labelledby="hs-heading-{{ Str::slug($title) }}">
        <div class="pb-4 px-5">{{ $slot }}</div>
    </div>
</div>
