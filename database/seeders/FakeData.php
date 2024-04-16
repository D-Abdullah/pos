<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Department;
use App\Models\Eol;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rent;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100 departments
        for ($i = 0; $i < 500; $i++) {
            Department::create([
                'name' => 'Department ' . ($i + 1),
                'description' => 'Description ' . ($i + 1),
                'added_by' => User::first()->id,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            $department = Department::inRandomOrder()->first();
            Product::create([
                'name' => 'Product ' . ($i + 1),
                'description' => 'Description ' . ($i + 1),
                'department_id' => $department->id,
                'added_by' => User::first()->id,
            ]);
        }

        $pt = ['cash', 'deposit', 'both'];
        for ($i = 0; $i < 500; $i++) {
            Supplier::create([
                'name' => 'Supplier ' . ($i + 1),
                'email' => 'supplier' . ($i + 1) . '@example.com',
                'phone' => '0123456789',
                'address' => 'address ' . ($i + 1),
                'payment_type' => $pt[array_rand($pt)],
                'added_by' => User::first()->id,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            $supplier = Supplier::inRandomOrder()->first();
            $product = Product::inRandomOrder()->first();
            $quantity = rand(100, 10000);
            $unit_price = rand(100, 5000);
            $total_price = $quantity * $unit_price;
            Purchase::create([
                'supplier_id' => $supplier->id,
                'date' => now(),
                'quantity' => $quantity,
                'total_price' => $total_price,
                'unit_price' => $unit_price,
                'added_by' => User::first()->id,
                'product_id' => $product->id,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            Client::create([
                'name' => 'Client ' . ($i + 1),
                'phone' => '0123456789',
                'added_by' => User::first()->id,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            $product = Product::inRandomOrder()->first();
            Eol::create([
                'product_id' => $product->id,
                'quantity' => rand(1, 1000),
                'reason' => 'reason ' . ($i + 1),
                'added_by' => User::first()->id,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            $rentPrice = rand(1, 1000);
            $salePrice = $rentPrice + rand(100, 500);
            $supplier = Supplier::inRandomOrder()->first();
            $qty = rand(200, 1000);
            Rent::create([
                'name' => 'Rent Item ' . ($i + 1),
                'rent_price' => $rentPrice,
                'sale_price' => $salePrice,
                'quantity' => $qty,
                'added_by' => User::first()->id,
                'supplier_id' => $supplier->id,
                'total_price' => $qty * $rentPrice
            ]);
        }
    }
}
