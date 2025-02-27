<div class="flex flex-col justify-center items-center gap-2 text-center">
    <time class="font-bold text-4xl text-slate-800">{{ $year }}</time>
    <div class="relative my-8 w-full flex flex-col justify-center items-center">
        <div class="absolute top-1/2 left-0 h-px w-full bg-slate-300"></div>
        <div class="relative h-8 w-8 rounded-full bg-rose-200 before:content-[''] before:w-2 before:h-2 before:bg-primary before:absolute before:top-1/2 before:left-1/2 before:rounded-lg before:-translate-x-1/2 before:-translate-y-1/2 hover:before:h-4 hover:before:w-4 before:transition-all"></div>
    </div>
    <div class="px-8">
        <h3 class="font-bold text-xl text-slate-800">{{ $title }}</h3>
        <div class="prose max-w-none mt-4">{{ $slot }}</div>
    </div>
</div>