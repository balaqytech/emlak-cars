@props(['items' => [], 'color' => 'slate-400'])

{{-- Add JSON-LD for Breadcrumbs --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "{{ __('frontend.home') }}",
            "item": "{{ localizedUrl('/') }}"
        }
        @foreach ($items as $index => $item)
        ,{
            "@type": "ListItem",
            "position": {{ $loop->iteration + 1 }},
            "name": "{{ $item['label'] }}",
            @if(!empty($item['url']))
                "item": "{{ $item['url'] }}"
            @endif
        }
        @endforeach
    ]
}
</script>

{{-- Render the Breadcrumb HTML --}}
<ol {{ $attributes }}>
    <li class="inline-flex items-center">
        <a class="flex items-center text-xs text-{{ $color }} hover:text-primary focus:outline-hidden focus:text-primary"
            href="{{ localizedUrl('/') }}" aria-label="{{ __('frontend.home') }}">
            {{ __('frontend.home') }}
        </a>
        @if (count($items) > 0)
            <x-icons.slash class="shrink-0 size-5 text-gray-400 mx-2" />
        @endif
    </li>

    @foreach ($items as $index => $item)
        <li class="inline-flex items-center">
            @if (!$loop->last)
                <a class="flex items-center text-xs text-{{ $color }} hover:text-primary focus:outline-hidden focus:text-primary"
                    href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] }}">
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
