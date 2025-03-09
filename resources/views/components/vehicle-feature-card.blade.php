<div class="flex flex-col bg-white border shadow-sm rounded-xl">
    <div class="w-full h-96">
        <img class="w-full h-full object-cover object-center rounded-t-xl" src="{{ asset('storage/' . $image) }}">
    </div>
    <div class="p-4 md:p-5">
        <h3 class="text-lg font-bold text-slate-800">
            {{ $title }}
        </h3>
        <p class="mt-1 text-slate-500">
            {{ $description }}
        </p>
    </div>
</div>
