@php
    use App\Models\Page;
    use App\Models\Post;
    use App\Models\Offer;
    use App\Models\Vehicle;

    $search = request('s', '');

    $postResults = Post::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orWhere('excerpt', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($post) {
            $post->slug = 'posts/' . $post->slug;
        });

    $pageResults = Page::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($page) {
            $page->slug = 'page/' . $page->slug;
        });

    $offerResults = Offer::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orWhere('excerpt', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($offer) {
            $offer->slug = 'offers/' . $offer->slug;
        });

    $vehicleResults = Vehicle::where('name', 'like', '%' . $search . '%')
        ->orWhere('overview', 'like', '%' . $search . '%')
        ->orWhere('features', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($vehicle) {
            $vehicle->title = $vehicle->name;
            $vehicle->slug = 'vehicles/' . $vehicle->slug;
        });

    $results = $postResults->merge($pageResults)->merge($offerResults)->merge($vehicleResults);
    // dd($results->first()->title);
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.search_result_for', ['s' => $search]) }}
    </x-slot>

    <section>
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 py-12">
                @forelse ($results as $result)
                    <x-search-card :post="$result" />
                @empty
                    nothing
                @endforelse
            </div>
        </div>
    </section>

</x-page-layout>
