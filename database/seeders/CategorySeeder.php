<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan foreign key checks sementara agar bisa truncate
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Unit Device
        $unit = \App\Models\Category::create(['name' => 'Unit Device']);
        \App\Models\Category::create(['name' => 'Laptop Gaming', 'parent_id' => $unit->id]);
        \App\Models\Category::create(['name' => 'Laptop Office', 'parent_id' => $unit->id]);
        \App\Models\Category::create(['name' => 'Ultrabook', 'parent_id' => $unit->id]);
        \App\Models\Category::create(['name' => 'PC Desktop', 'parent_id' => $unit->id]);

        // 2. Sparepart / Komponen
        $sparepart = \App\Models\Category::create(['name' => 'Sparepart / Komponen']);
        \App\Models\Category::create(['name' => 'RAM DDR3/DDR4', 'parent_id' => $sparepart->id]);
        \App\Models\Category::create(['name' => 'SSD SATA/NVMe', 'parent_id' => $sparepart->id]);
        \App\Models\Category::create(['name' => 'LCD', 'parent_id' => $sparepart->id]);
        \App\Models\Category::create(['name' => 'Caddy', 'parent_id' => $sparepart->id]);

        // 3. Aksesoris
        $aksesoris = \App\Models\Category::create(['name' => 'Aksesoris']);
        \App\Models\Category::create(['name' => 'Flashdisk', 'parent_id' => $aksesoris->id]);
        \App\Models\Category::create(['name' => 'Tas', 'parent_id' => $aksesoris->id]);
        \App\Models\Category::create(['name' => 'Mouse', 'parent_id' => $aksesoris->id]);

        // 4. Software / Digital
        $software = \App\Models\Category::create(['name' => 'Software / Digital']);
        \App\Models\Category::create(['name' => 'Lisensi Windows', 'parent_id' => $software->id]);
        \App\Models\Category::create(['name' => 'Lisensi Antivirus', 'parent_id' => $software->id]);
        \App\Models\Category::create(['name' => 'Jasa Instalasi', 'parent_id' => $software->id]);
    }
}
