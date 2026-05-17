<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@lktech.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('Admin');

        // Create Staff user
        $staff = User::firstOrCreate(
            ['email' => 'staff@lktech.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
            ]
        );
        $staff->assignRole('Staff');

        // Create categories
        $categories = [
            ['name' => 'Laptop Gaming'],
            ['name' => 'Laptop Office'],
            ['name' => 'Laptop Ultrabook'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }

        // Get category IDs
        $gamingCategory = Category::where('name', 'Laptop Gaming')->first();
        $officeCategory = Category::where('name', 'Laptop Office')->first();

        // Create products with some having low battery health for alerts
        $products = [
            [
                'category_id' => $gamingCategory->id,
                'brand' => 'ASUS',
                'model_series' => 'ROG Strix G15',
                'serial_number' => 'ASUS-ROG-001',
                'processor' => 'Intel Core i7-11800H',
                'ram' => '16GB DDR4',
                'storage' => '512GB SSD',
                'screen_size' => 15.6,
                'battery_health' => 85,
                'battery_runtime' => 2.5,
                'condition' => 'Mulus seperti baru',
                'purchase_price' => 15000000,
                'selling_price' => 17500000,
                'status' => 'available',
            ],
            [
                'category_id' => $officeCategory->id,
                'brand' => 'Lenovo',
                'model_series' => 'ThinkPad T14',
                'serial_number' => 'LENOVO-TP-002',
                'processor' => 'Intel Core i5-10210U',
                'ram' => '8GB DDR4',
                'storage' => '256GB SSD',
                'screen_size' => 14.0,
                'battery_health' => 65, // Low battery for alert
                'battery_runtime' => 1.8,
                'condition' => 'Bekas pemakaian normal',
                'purchase_price' => 8000000,
                'selling_price' => 9500000,
                'status' => 'available',
            ],
            [
                'category_id' => $gamingCategory->id,
                'brand' => 'MSI',
                'model_series' => 'GF63 Thin',
                'serial_number' => 'MSI-GF63-003',
                'processor' => 'Intel Core i5-10500H',
                'ram' => '16GB DDR4',
                'storage' => '1TB SSD',
                'screen_size' => 15.6,
                'battery_health' => 72,
                'battery_runtime' => 3.0,
                'condition' => 'Mulus',
                'purchase_price' => 12000000,
                'selling_price' => 14000000,
                'status' => 'sold',
            ],
            [
                'category_id' => $officeCategory->id,
                'brand' => 'HP',
                'model_series' => 'Pavilion 14',
                'serial_number' => 'HP-PV14-004',
                'processor' => 'AMD Ryzen 5 5500U',
                'ram' => '8GB DDR4',
                'storage' => '512GB SSD',
                'screen_size' => 14.0,
                'battery_health' => 58, // Low battery for alert
                'battery_runtime' => 2.2,
                'condition' => 'Bekas garansi resmi',
                'purchase_price' => 9000000,
                'selling_price' => 10500000,
                'status' => 'available',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['serial_number' => $product['serial_number']], $product);
        }

        // Create some sales data
        $soldProduct = Product::where('status', 'sold')->first();
        if ($soldProduct) {
            $sale = Sale::create([
                'user_id' => $admin->id,
                'customer_name' => 'Budi Santoso',
                'total_amount' => $soldProduct->selling_price,
                'profit_amount' => $soldProduct->selling_price - $soldProduct->purchase_price,
                'transaction_date' => now()->subDays(5),
            ]);

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $soldProduct->id,
                'price_at_transaction' => $soldProduct->selling_price,
            ]);
        }
    }
}
