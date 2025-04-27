<article
    class="flex flex-col bg-white shadow-3xl rounded-lg border border-slate-200 overflow-hidden hover:-translate-y-1 transition-all duration-500">
    <a href="{{ localizedUrl($post->slug) }}" class="relative h-80">
        <img loading="lazy" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
            class="w-full h-full object-cover object-center">
    </a>
    <div class="p-10 flex flex-col gap-2 grow">
        <h3 class="text-xl font-bold text-slate-700">
            <a href="{{ localizedUrl($post->slug) }}" class="hover:underline hover:text-primary">{{ $post->title }}</a>
        </h3>
        <a href="{{ localizedUrl($post->slug) }}"
            class="text-primary hover:underline mt-2 inline-block">{{ __('frontend.posts.read_more') }}</a>
    </div>
</article>
