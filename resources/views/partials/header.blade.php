<header x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false"
    class=" w-full bg-white text-sm py-3 border-b border-gray-200 z-50 shadow-3xl">
    <nav class="wrapper flex items-center justify-between gap-4">
        <a class="flex-none text-xl font-semibold focus:outline-none focus:opacity-80" href="{{ localizedUrl('/') }}"
            aria-label="Brand">
            <img loading="lazy" class="h-16" src="{{ asset('storage/' . general_settings('site_logo')) }}"
                alt="{{ general_settings('site_name') }}">
        </a>
        <ul class="hidden items-center md:flex gap-8 justify-center">
            <x-nav-link link="{{ localizedUrl('/') }}" title="{{ __('frontend.navigation.home') }}" />
            <x-nav-link link="{{ localizedUrl('/vehicles') }}" title="{{ __('frontend.navigation.vehicles') }}" />
            <x-nav-link link="{{ localizedUrl('/offers') }}" title="{{ __('frontend.navigation.offers') }}" />
            <x-nav-link link="{{ localizedUrl('/posts') }}" title="{{ __('frontend.navigation.posts') }}" />
            <x-nav-link link="{{ localizedUrl('/branches') }}" title="{{ __('frontend.navigation.branches') }}" />
            <x-nav-link link="{{ localizedUrl('/about') }}" title="{{ __('frontend.navigation.about') }}" />
            <x-nav-link link="{{ app()->getLocale() == 'ar' ? '/en' : '/ar' }}" title="{{ app()->getLocale() == 'ar' ? 'English' : 'عربي' }}" />
        </ul>
        <div class="flex items-center gap-4">
            <x-primary-button href="{{ localizedUrl('/contact') }}" class="hidden md:block">{{ __('frontend.navigation.contact') }}</x-primary-button>
            <x-search-modal />
        </div>
        <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
            class="flex text-on-surface dark:text-on-surface-dark md:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
            <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        {{-- mobile menu --}}
        <ul x-cloak x-show="mobileMenuIsOpen"
            x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" id="mobileMenu"
            class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col bg-white divide-y divide-outline rounded-b-radius border-b border-outline bg-surface-alt px-6 pb-6 pt-20">
            <x-nav-link link="{{ localizedUrl('/') }}" title="{{ __('frontend.navigation.home') }}" />
            <x-nav-link link="{{ localizedUrl('/vehicles') }}" title="{{ __('frontend.navigation.vehicles') }}" />
            <x-nav-link link="{{ localizedUrl('/offers') }}" title="{{ __('frontend.navigation.offers') }}" />
            <x-nav-link link="{{ localizedUrl('/posts') }}" title="{{ __('frontend.navigation.posts') }}" />
            <x-nav-link link="{{ localizedUrl('/branches') }}" title="{{ __('frontend.navigation.branches') }}" />
            <x-nav-link link="{{ localizedUrl('/about') }}" title="{{ __('frontend.navigation.about') }}" />
            <x-nav-link link="{{ localizedUrl('/contact') }}" title="{{ __('frontend.navigation.contact') }}" />
            <x-nav-link link="{{ app()->getLocale() == 'ar' ? '/en' : '/ar' }}" title="{{ app()->getLocale() == 'ar' ? 'English' : 'عربي' }}" />
        </ul>
    </nav>
</header>
