<div class="bg-gradient-to-r from-blue-50 via-cyan-50/70 to-emerald-50 py-6 px-4 sm:px-6 lg:px-8 text-center border-b border-cyan-100/70 w-full">
    <h1 class="text-xl md:text-2xl font-bold font-montserrat text-blue-900 mb-1.5 tracking-tight">{{ $title }}</h1>
    @if(isset($subtitle))
        <p class="text-gray-600 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed">{{ $subtitle }}</p>
    @endif
</div>
