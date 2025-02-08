<div x-data="{ isExpanded: false }">
    <button id="controlsAccordionItemOne" type="button"
        class="flex w-full items-center justify-between gap-4 bg-white p-4 underline-offset-2 "
        aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded"
        x-bind:class="isExpanded ? 'font-bold' : 'font-medium'"
        x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
        {{ $title }}
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
            stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
            x-bind:class="isExpanded ? 'rotate-180' : ''">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
    <div x-cloak x-show="isExpanded" role="region"
        aria-labelledby="controlsAccordionItemOne" x-collapse
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90">
        <div class="p-4 text-sm sm:text-base text-pretty">
            {{ $slot }}
        </div>
    </div>
</div>