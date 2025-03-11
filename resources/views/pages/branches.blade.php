@php
    use App\Models\Branch;

    $branches = Branch::all();
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.branches.page_title') }}
    </x-slot>

    <section x-data="{ mapEmbed : '{{ $branches->first()->map_embed }}' }">
        <div class="wrapper py-24">
            <h2 class="text-3xl font-bold text-center text-slate-800">{{ __('frontend.branches.heading') }}</h2>
            <p class="text-center mt-4 text-slate-600">{{ __('frontend.branches.subheading') }}</p>

            @if ($branches->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-8">
                    <div class="h-[70vh] overflow-y-scroll mt-8 p-4 space-y-8">
                        @foreach ($branches as $branch)
                            <div id="branch-details" class="bg-white shadow-lg rounded-lg p-8 cursor-pointer"
                                @click="mapEmbed = '{{ $branch->map_embed }}'">
                                <h3 class="text-xl font-bold text-slate-800">{{ $branch->name }}</h3>
                                <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm text-slate-600">
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.map-pin class="size-4" />
                                        </span>
                                        <span class="text-slate-800 dark:text-neutral-400">
                                            {{ __('frontend.branches.address') }}: {{ $branch->address }}
                                        </span>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.phone class="size-4" />
                                        </span>
                                        <a href="tel:{{ $branch->contact_mobile }}" class="text-slate-800 hover:underline">
                                            {{ __('frontend.branches.contact_mobile') }}: <span dir="ltr">{{ $branch->contact_mobile }}</span>
                                        </a>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.whatsapp class="size-4" />
                                        </span>
                                        <a href="https://wa.me/{{ $branch->contact_whatsapp }}" target="_blank" class="text-slate-800 hover:underline">
                                            {{ __('frontend.branches.contact_whatsapp') }}: {{ $branch->contact_whatsapp }}
                                        </a>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 shrink-0 inline-flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.clock class="size-4" />
                                        </span>
                                        <span class="text-slate-800 dark:text-neutral-400">
                                            {{ __('frontend.branches.working_hours') }}: {{ $branch->working_hours }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                    <div class="w-full">
                        <div id="map-embed" x-html="mapEmbed" class="overflow-x-auto h-full w-full object-contain object-center"></div>
                    </div>
                </div>
            @else
                <div class="mt-8">
                    <x-icons.question class="block mx-auto size-24 text-primary" />
                    <p class="text-center">{{ __('frontend.branches.no_branches') }}</p>
                </div>
            @endif
        </div>
    </section>

</x-page-layout>
