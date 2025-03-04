<div x-data="{ isExpanded: false }" class="bg-white border -mt-px first:rounded-t-lg last:rounded-b-lg">
    <button id="controlsAccordionItem{{ Str::slug($title) }}" type="button"
        class="inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 focus:outline-none focus:text-gray-500 rounded-lg"
        aria-controls="accordionItem{{ Str::slug($title) }}" x-on:click="isExpanded = ! isExpanded"
        x-bind:class="isExpanded ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold' :
            'text-on-surface dark:text-on-surface-dark font-medium'"
        x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
        <x-icons.plus x-show="!isExpanded" class="size-3.5" />
        <x-icons.minus x-show="isExpanded"  class="size-3.5" />
        {{ $title }}
    </button>
    <div x-cloak x-show="isExpanded" id="accordionItem{{ Str::slug($title) }}" role="region" aria-labelledby="controlsAccordionItem{{ Str::slug($title) }}"
        x-collapse>
        <div class="pb-4 px-5">{{ $slot }}</div>
    </div>
</div>
