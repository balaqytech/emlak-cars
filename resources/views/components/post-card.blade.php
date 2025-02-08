<article class="flex flex-col bg-white shadow-3xl rounded-lg border border-slate-200 overflow-hidden hover:-translate-y-1 transition-all duration-500">
    <a href="/posts/{{ $post->slug }}">
        <img src="{{ asset('storage/'. $post->image) }}" alt="{{ $post->title }}" class="w-full h-80 object-cover object-center">
    </a>
    <div class="p-10 flex flex-col gap-2">
        <h3 class="text-xl font-bold text-slate-700">
            <a href="/posts/{{ $post->slug }}" class="hover:underline hover:text-primary">Post Title</a>
        </h3>
        <p class="text-gray-600 text-sm flex items-center gap-2">
            <x-icons.calendar class="w-4 h-4 inline-block text-primary"></x-icons.calendar>
            <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d/m/Y') }}</time>
        </p>
        <p class="mt-2 text-gray-800">{{ $post->excerpt ?? \Illuminate\Support\Str::words($post->content, 15, '...') }}</p>
        <a href="/posts/{{ $post->slug }}" class="text-primary hover:underline mt-2 inline-block">{{ __('frontend.read_more') }}</a>
    </div>
</article>
