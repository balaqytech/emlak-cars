<li class="py-4">
    <a class="{{ request()->is(ltrim($link, '/')) ? 'text-primary underline font-bold' : 'text-slate-600' }} hover:text-slate-400 focus:outline-none focus:text-slate-400"
        href="{{ $link }}">{{ $title }}</a>
</li>