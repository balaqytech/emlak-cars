<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" autocomplete="{{ $name }}" {{ $attributes }}
        class="py-3 px-4 block w-full border-slate-200 border rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
        placeholder="{{ $label }}">
    @if ($errors->has($name))
    <span class="text-red-500 text-sm">{{ $errors->first($name) }}</span>
    @endif
</div>