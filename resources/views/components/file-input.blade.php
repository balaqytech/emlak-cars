<div class="max-w-sm">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $attributes }}
        class="block w-full border border-slate-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none file:bg-slate-50 file:border-0 file:me-4 file:py-3 file:px-4">
        @if ($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @endif
</div>
