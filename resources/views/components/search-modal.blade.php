<div x-data="{ modalIsOpen: false }">
    <x-primary-button x-on:click="modalIsOpen = true" class=""><x-icons.search
            class="size-5 text-white" /></x-primary-button>
    <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
        x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false"
        class="fixed inset-0 z-30 flex items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
        <!-- Modal Dialog -->
        <div x-show="modalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
            class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">

            <form action="{{ localizedUrl('/search') }}" method="GET" class="w-full">
                <div
                    class="relative z-10 flex gap-x-3 p-3 bg-white border border-gray-200 rounded-lg shadow-lg shadow-gray-100 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-gray-900/20">
                    <div class="w-full grow">
                        <label for="s" class="block text-sm text-gray-700 font-medium dark:text-white"><span
                                class="sr-only">Search...</span></label>
                        <input type="text" name="s" id="s"
                            class="py-2.5 px-4 block w-full border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="{{ __('frontend.search_placeholder') }}" required>
                    </div>
                    <div class="max-w-10">
                        <button type="submit"
                            class="w-full p-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-rose-700 focus:outline-none focus:bg-primary disabled:opacity-50 disabled:pointer-events-none"><x-icons.search
                                class="size-5 text-white" /></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
