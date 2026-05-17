@php
    // Get current route name and URL segments
    $currentRoute = request()->route()->getName();
    $segments = request()->segments();
    
    // Define breadcrumb mappings
    $breadcrumbMap = [
        'dashboard' => 'Dashboard',
        'products.index' => 'Manajemen Inventaris',
        'products.create' => 'Tambah Produk',
        'products.edit' => 'Edit Produk',
        'products.show' => 'Detail Produk',
        'sales.index' => 'Penjualan',
        'sales.create' => 'Tambah Transaksi',
        'sales.edit' => 'Edit Transaksi',
        'sales.show' => 'Detail Transaksi',
        'sales.invoice' => 'Invoice',
        'activity-logs.index' => 'Log Aktivitas',
        'reports.index' => 'Reports',
        'reports.profit' => 'Laporan Laba Rugi',
        'laporan.index' => 'Laporan',
        'profile.edit' => 'Edit Profil',
        'password.change' => 'Ubah Password',
    ];
    
    // Define segment mappings for dynamic URLs
    $segmentMap = [
        'products' => 'Manajemen Inventaris',
        'sales' => 'Penjualan',
        'activity-logs' => 'Log Aktivitas',
        'reports' => 'Laporan',
        'laporan' => 'Laporan',
        'profile' => 'Profil',
        'password' => 'Password',
    ];
    
    // Build breadcrumbs array
    $breadcrumbs = [];
    $urlPath = '';
    
    // Always start with Dashboard
    $breadcrumbs[] = [
        'name' => 'Dashboard',
        'url' => route('dashboard'),
        'active' => $currentRoute === 'dashboard'
    ];
    
    // Build breadcrumbs from URL segments
    foreach ($segments as $index => $segment) {
        $urlPath .= '/' . $segment;
        
        // Skip if it's the first segment and matches dashboard
        if ($index === 0 && $segment === 'dashboard') {
            continue;
        }
        
        // Skip 'reports' segment if current route is reports.profit
        if ($segment === 'reports' && $currentRoute === 'reports.profit') {
            continue;
        }
        
        $name = $segmentMap[$segment] ?? ucfirst($segment);
        $isLast = $index === count($segments) - 1;
        
        // Check if this is current active page
        $active = $isLast;
        
        // Try to get route name for more accurate mapping
        if ($isLast && isset($breadcrumbMap[$currentRoute])) {
            $name = $breadcrumbMap[$currentRoute];
        }
        
        // Special handling for create/edit/show actions
        if (in_array($segment, ['create', 'edit', 'show']) && $index > 0) {
            $parentSegment = $segments[$index - 1] ?? '';
            $parentName = $segmentMap[$parentSegment] ?? ucfirst($parentSegment);
            
            if ($segment === 'create') {
                $name = 'Tambah ' . str_replace('Manajemen ', '', $parentName);
            } elseif ($segment === 'edit') {
                $name = 'Edit ' . str_replace('Manajemen ', '', $parentName);
            } elseif ($segment === 'show') {
                $name = 'Detail ' . str_replace('Manajemen ', '', $parentName);
            }
        }
        
        $breadcrumbs[] = [
            'name' => $name,
            'url' => $active ? null : $urlPath,
            'active' => $active
        ];
    }
@endphp

@if(count($breadcrumbs) > 1)
<nav class="bg-white border-b border-gray-200 px-4 py-3">
    <ol class="flex items-center space-x-2 text-sm font-sans overflow-x-auto">
        @foreach($breadcrumbs as $index => $breadcrumb)
            @if($index > 0)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
            @endif
            
            <li class="flex items-center">
                @if($breadcrumb['url'] && !$breadcrumb['active'])
                    <a href="{{ $breadcrumb['url'] }}" 
                       class="text-gray-600 hover:text-lk-navy transition-colors duration-200 whitespace-nowrap">
                        {{ $breadcrumb['name'] }}
                    </a>
                @else
                    <span class="text-lk-navy font-medium whitespace-nowrap">
                        {{ $breadcrumb['name'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
