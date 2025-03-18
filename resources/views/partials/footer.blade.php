@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;
    use App\Models\Page;

    $pages = cache()->remember('pages', now()->addDay(), function () {
        return Page::all();
    });

    $contact_email = FilamentFlatPage::get('contact.json', 'contact_email');
    $contact_phone = FilamentFlatPage::get('contact.json', 'contact_phone');
@endphp

<footer class="mt-24">
    <div class="wrapper relative overflow-hidden bg-slate-50 rounded-xl border border-slate-200">
        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-12 py-24">
            <div class="col-span-2 md:col-span-1 lg:col-span-1">
                <a class="flex-none h-24 font-semibold text-xl text-black focus:outline-none focus:opacity-80"
                    href="{{ localizedUrl('/') }}" aria-label="Brand">
                    <img loading="lazy" class="object-contain object-center"
                        src="{{ asset('storage/' . general_settings('site_logo')) }}"
                        alt="{{ general_settings('site_name') }}">
                </a>
                <p class="mt-8 text-xs sm:text-sm text-slate-600">
                    {{ general_settings('site_tagline') }}
                </p>
            </div>

            <div>
                <h4 class="text-md font-semibold text-slate-900 uppercase">{{ __('frontend.footer.company_title') }}
                </h4>
                <div class="mt-3 grid space-y-3 text-sm">
                    <x-footer-nav-link link="{{ localizedUrl('/about') }}"
                        title="{{ __('frontend.navigation.about') }}" />
                    <x-footer-nav-link link="{{ localizedUrl('/vehicles') }}"
                        title="{{ __('frontend.navigation.vehicles') }}" />
                    <x-footer-nav-link link="{{ localizedUrl('/branches') }}"
                        title="{{ __('frontend.navigation.branches') }}" />
                    <x-footer-nav-link link="{{ localizedUrl('/offers') }}"
                        title="{{ __('frontend.navigation.offers') }}" />
                    <x-footer-nav-link link="{{ localizedUrl('/posts') }}"
                        title="{{ __('frontend.navigation.posts') }}" />
                    <x-footer-nav-link link="{{ localizedUrl('/contact') }}"
                        title="{{ __('frontend.navigation.contact') }}" />
                    <x-footer-nav-link link="{{ app()->getLocale() == 'ar' ? '/en' : '/ar' }}"
                        title="{{ app()->getLocale() == 'ar' ? 'English' : 'عربي' }}" />
                </div>
            </div>
            <!-- End Col -->
            <div>
                <h4 class="text-md font-semibold text-slate-900 uppercase">{{ __('frontend.footer.quick_links') }}</h4>
                <div class="mt-3 grid space-y-3 text-sm">
                    {{-- <x-footer-nav-link link="{{ localizedUrl('/installment-calculator') }}"
                        title="{{ __('frontend.navigation.installment_calculator') }}" /> --}}
                    <x-footer-nav-link link="{{ localizedUrl('/faqs') }}"
                        title="{{ __('frontend.navigation.faqs') }}" />
                    @foreach ($pages as $page)
                        <x-footer-nav-link link="{{ localizedUrl('/page/' . $page->slug) }}"
                            title="{{ $page->title }}" />
                    @endforeach
                </div>
            </div>
            <!-- End Col -->
            <div class="col-span-2 md:col-span-1 lg:col-span-1">
                <h4 class="text-ةي font-semibold text-slate-900 uppercase">{{ __('frontend.footer.contact_us') }}</h4>
                <ul class="mt-3 grid gap-4">
                    <li
                        class="inline-flex items-center gap-x-3.5 text-sm font-medium text-slate-800 hover:text-primary hover:underline">
                        <a href="tel:{{ $contact_phone }}" class="flex items-center gap-x-2">
                            <x-icons.phone class="w-5 h-5" />
                            <span dir="ltr">{{ $contact_phone }}</span>
                        </a>
                    </li>
                    <li
                        class="inline-flex items-center gap-x-3.5 text-sm font-medium text-slate-800 hover:text-primary hover:underline">
                        <a href="mailto:{{ $contact_email }}" class="flex items-center gap-x-2">
                            <x-icons.envlope class="w-5 h-5" />
                            {{ $contact_email }}
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Col -->
        </div>
    </div>
    <!-- End Grid -->

    <div class="wrapper py-3 mt-5 border-t border-slate-200">
        <div class="flex flex-col-reverse items-center sm:flex-row sm:items-center sm:justify-between gap-4">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                    href="{{ url('/') }}" class="hover:underline">{{ general_settings('site_name') }}™</a>.
                {{ __('frontend.footer.copyrights_reserved') }}
            </span>
            <div class="flex mt-4 gap-4 sm:justify-center sm:mt-0">
                <a href="{{ general_settings('facebook') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.facebook class="w-5 h-5" />
                </a>
                <a href="{{ general_settings('snapchat') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.snapchat class="w-5 h-5" />
                </a>
                <a href="{{ general_settings('twitter') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.twitter-x class="w-5 h-5" />
                </a>
                <a href="{{ general_settings('instagram') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.instagram class="w-5 h-5" />
                </a>
                <a href="{{ general_settings('linkedin') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.linkedin class="w-5 h-5" />
                </a>
                <a href="{{ general_settings('youtube') }}" target="_blank"
                    class="text-slate-600 hover:text-primary focus:outline-none focus:text-primary">
                    <x-social.youtube class="w-5 h-5" />
                </a>
            </div>
        </div>
    </div>
    <a href="{{ general_settings('whatsapp') }}" target="_blank"
        class="fixed bottom-4 end-4 bg-[#25d366] hover:bg-[#128c7e] text-white font-bold p-4 rounded-full shadow-lg">
        <x-icons.whatsapp class="size-8" />
    </a>
</footer>
