@props(['name', 'label', 'error' => false, 'placeholder' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    <div class="relative">
        <input type="number" id="{{ $name }}" name="{{ $name }}"
            class="py-3 px-4 pe-11 block w-full border border-slate-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
            placeholder="{{ $placeholder }}" {{ $attributes }}>
        <div class="absolute inset-y-0 end-2 flex items-center pointer-events-none z-20 ps-4">
            <x-icons.sar class="shrink-0 size-4" />
        </div>
    </div>
    @if ($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @endif
</div>
