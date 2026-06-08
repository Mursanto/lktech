<div class="bg-gradient-to-b from-blue-100 to-blue-50 pt-16 pb-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-[3rem] border-b border-blue-200 shadow-sm mb-10 w-full max-w-7xl mx-auto">
    <h1 class="text-3xl md:text-5xl font-bold font-montserrat text-blue-900 mb-4 tracking-tight">{{ $title }}</h1>
    @if(isset($subtitle))
        <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">{{ $subtitle }}</p>
    @endif
</div>
