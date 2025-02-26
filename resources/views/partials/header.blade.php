<header class="sticky flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3">
    <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center justify-between">
            <a class="flex-none text-xl font-semibold focus:outline-none focus:opacity-80" href="#"
                aria-label="Brand">
                <img class="h-16" src="{{ asset('storage/' . general_settings('site_logo')) }}" alt="{{ general_settings('site_name') }}">
            </a>
            <div class="sm:hidden">
                <button type="button"
                    class="hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                    id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example"
                    aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-example">
                    <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                    <span class="sr-only">Toggle navigation</span>
                </button>
            </div>
        </div>
        <div id="hs-navbar-example"
            class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block"
            aria-labelledby="hs-navbar-example-collapse">
            <nav class="flex flex-col gap-5 text-base mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                <x-nav-link link="/" title="{{ __('frontend.navigation.home') }}" />
                <x-nav-link link="/about" title="{{ __('frontend.navigation.about') }}" />
                <x-nav-link link="/offers" title="{{ __('frontend.navigation.offers') }}" />
                <x-nav-link link="/posts" title="{{ __('frontend.navigation.posts') }}" />
                <x-nav-link link="/installment-calculator" title="{{ __('frontend.navigation.installment_calculator') }}" />
                <x-nav-link link="/contact" title="{{ __('frontend.navigation.contact') }}" />
            </nav>
        </div>
    </nav>
</header>
