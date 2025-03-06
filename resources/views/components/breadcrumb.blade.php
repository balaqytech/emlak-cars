@props(['items' => [], 'color' => 'slate-400'])

<ol {{ $attributes }}>
    <li class="inline-flex items-center">
        <a class="flex items-center text-xs text-{{ $color }} hover:text-primary focus:outline-hidden focus:text-primary"
            href="/">
            {{ __('frontend.home') }}
        </a>
        @if(count($items) > 0)
            <x-icons.slash class="shrink-0 size-5 text-gray-400 mx-2" />
        @endif
    </li>

    @foreach ($items as $index => $item)
        <li class="inline-flex items-center">
            @if (!$loop->last)
                <a class="flex items-center text-xs text-{{ $color }} hover:text-primary focus:outline-hidden focus:text-primary"
                    href="{{ $item['url'] ?? '#' }}">
                    {{ $item['label'] }}
                    <x-icons.slash class="shrink-0 size-5 text-gray-400 mx-2" />
                </a>
            @else
                <span class="inline-flex items-center text-xs text-{{ $color }} truncate" aria-current="page">
                    {{ $item['label'] }}
                </span>
            @endif
        </li>
    @endforeach
</ol>
