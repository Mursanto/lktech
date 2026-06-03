<?php

use App\Models\Category;

// 1. Unit Device (ID: 1)
$unitDevice = Category::firstOrCreate(['name' => 'Unit Device'], ['type_category' => 'hardware']);

// Ensure subcategories are under Unit Device
$unitSubs = ['Laptop Gaming', 'Laptop Office', 'Ultrabook', 'PC Desktop'];
foreach ($unitSubs as $sub) {
    Category::updateOrCreate(['name' => $sub], ['parent_id' => $unitDevice->id, 'type_category' => 'hardware']);
}

// 2. Sparepart / Komponen (ID: 6)
$sparepart = Category::firstOrCreate(['name' => 'Sparepart / Komponen'], ['type_category' => 'peripheral']);
$sparepartSubs = ['RAM DDR3/DDR4', 'SSD SATA/NVMe', 'LCD', 'Caddy'];
foreach ($sparepartSubs as $sub) {
    Category::updateOrCreate(['name' => $sub], ['parent_id' => $sparepart->id, 'type_category' => 'peripheral']);
}

// Move HDD under Sparepart and rename slightly if needed, or just update parent_id
$hdd = Category::where('name', 'HDD (Hardisk)')->first();
if ($hdd) {
    $hdd->parent_id = $sparepart->id;
    $hdd->save();
} else {
    Category::create(['name' => 'HDD (Hardisk)', 'parent_id' => $sparepart->id, 'type_category' => 'peripheral']);
}

// 3. Aksesoris (ID: 11)
$aksesoris = Category::firstOrCreate(['name' => 'Aksesoris'], ['type_category' => 'peripheral']);
$aksesorisSubs = ['Flashdisk', 'Tas', 'Mouse', 'Keyboard', 'Webcam'];
foreach ($aksesorisSubs as $sub) {
    Category::updateOrCreate(['name' => $sub], ['parent_id' => $aksesoris->id, 'type_category' => 'peripheral']);
}

// 4. Software / Digital (ID: 15)
$software = Category::firstOrCreate(['name' => 'Software / Digital'], ['type_category' => 'software']);
$softwareSubs = ['Lisensi Windows', 'Lisensi Microsoft Office', 'Lisensi Adobereader', 'Lisensi Antivirus'];
foreach ($softwareSubs as $sub) {
    Category::updateOrCreate(['name' => $sub], ['parent_id' => $software->id, 'type_category' => 'software']);
}

// 5. Jasa (New Category)
$jasa = Category::firstOrCreate(['name' => 'Jasa'], ['type_category' => 'service']);
$jasaSubs = ['Jasa Instalasi', 'Jasa Perbaikan / service', 'Jasa Pembuatan Website'];
foreach ($jasaSubs as $sub) {
    Category::updateOrCreate(['name' => $sub], ['parent_id' => $jasa->id, 'type_category' => 'service']);
}

echo "Categories restructured successfully.\n";
