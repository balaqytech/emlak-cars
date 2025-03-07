<div>
    <label for="{{ $name }}" class="block text-sm font-medium mb-2 dark:text-white">{{ $label }}</label>
    <div class="relative">
        <select id="{{ $name }}" name="{{ $name }}"
            class="py-3 px-4 pe-16 block w-full border border-slate-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}>
            <option selected="">{{ __('frontend.select_option') }}</option>
            {{ $slot }}
        </select>
        @if ($error)
            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-8">
                <x-icons.question class="shrink-0 size-4 text-red-500" />
            </div>
        @endif
    </div>
    @if ($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @endif
</div>
