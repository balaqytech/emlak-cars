<div class="col-span-full">
    <label for="{{ $name }}" class="">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="4" {{ $attributes }}
        class="py-3 px-4 block w-full border-slate-200 border rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
        placeholder="{{ $label }}"></textarea>
    @if ($errors->has($name))
        <span class="text-red-500 text-sm">{{ $errors->first($name) }}</span>
    @endif
</div>
