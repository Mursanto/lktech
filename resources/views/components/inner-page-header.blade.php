<div class="bg-gradient-to-b from-blue-100 to-blue-50 pt-8 pb-6 px-4 sm:px-6 lg:px-8 text-center rounded-b-[1.5rem] border-b border-blue-200 shadow-sm mb-6 w-full max-w-7xl mx-auto">
    <h1 class="text-2xl md:text-4xl font-bold font-montserrat text-blue-900 mb-2 tracking-tight">{{ $title }}</h1>
    @if(isset($subtitle))
        <p class="text-gray-600 text-sm md:text-base max-w-2xl mx-auto">{{ $subtitle }}</p>
    @endif
</div>
