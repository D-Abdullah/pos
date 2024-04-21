<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Eol;
use App\Models\FinancialTransaction;
use App\Models\FinancialTransactionType;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rent;
use App\Models\Safe;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WarehouseTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // departments
            $department = Department::create([
                'name' => 'Department ' . ($i + 1),
                'description' => 'Description ' . ($i + 1),
                'added_by' => User::first()->id,
            ]);
            // products
            for ($j = 0; $j < 2; $j++) {
                $product = Product::create([
                    'name' => 'Product ' . (($i + 1) + ($j + 1)),
                    'quantity' => 100,
                    'description' => 'Description ' . (($i + 1) + ($j + 1)),
                    'department_id' => $department->id,
                    'added_by' => User::first()->id,
                    'unit_price' => rand(10, 1000)
                ]);
                // suppliers
                $pt = ['cash', 'deposit', 'both'];
                for ($k = 0; $k < 2; $k++) {
                    $supplier = Supplier::create([
                        'name' => 'Supplier ' . ($k + 1),
                        'email' => 'supplier' . ($k + 1) . '@example.com',
                        'phone' => '0123456789',
                        'address' => 'address ' . ($k + 1),
                        'payment_type' => $pt[array_rand($pt)],
                        'added_by' => User::first()->id,
                    ]);
                    // rent
                    for ($z = 0; $z < 2; $z++) {
                        $rentPrice = rand(1, 1000);
                        $qtyZ = rand(200, 1000);
                        $rent = Rent::create([
                            'name' => 'Rent Item ' . ($z + 1),
                            'rent_price' => $rentPrice,
                            'quantity' => $qtyZ,
                            'added_by' => User::first()->id,
                            'supplier_id' => $supplier->id,
                            'total_price' => $qtyZ * $rentPrice
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => null,
                            'rent_id' => $rent->id,
                            'quantity' => $qtyZ,
                            'from' => 'المورد: ' . $supplier->name,
                            'to' => "مخزن الإيجار",
                            'type' => 'rent',
                        ]);
                    }
                    // purchases
                    for ($x = 0; $x < 2; $x++) {
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

                        $product->update(['quantity' => $product->quantity + $quantity]);

                        WarehouseTransaction::create([
                            'product_id' => $product->id,
                            'rent_id' => null,
                            'quantity' => $quantity,
                            'from' => 'المورد: ' . $supplier->name,
                            'to' => "المخزن",
                            'type' => 'purchases',
                        ]);
                    }
                    // Eol
                    for ($a = 0; $a < 2; $a++) {
                        $qty = rand(1, 1000);
                        Eol::create([
                            'product_id' => $product->id,
                            'quantity' => $qty,
                            'reason' => 'reason ' . ($a + 1),
                            'added_by' => User::first()->id,
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => $product->id,
                            'rent_id' => null,
                            'quantity' => $qty,
                            'from' => "المخزن",
                            'to' => 'هالك',
                            'type' => 'eol',
                        ]);
                    }
                }
            }
        }
        // employee
        for ($x = 0; $x < 100; $x++) {
            $emp = Employee::create([
                'name' => 'employee ' . ($x + 1),
                'phone' => '0123456789',
                'custody' => rand(100, 10000),
                'added_by' => User::first()->id,
            ]);
            // ftTypes
            for ($i = 0; $i < 2; $i++) {
                $ft = FinancialTransactionType::create([
                    'name' => 'safe ' . ($i + 1),
                    'added_by' => User::first()->id,
                ]);
                $type = ['income', 'expense'];
                for ($j = 0; $j < 2; $j++) {
                    FinancialTransaction::create([
                        'type' => $type[array_rand($type)],
                        'description' => 'description ' . ($j + 1),
                        'amount' => rand(100, 1000),
                        'party_id' => null,
                        'financial_transaction_type_id' => $ft->id,
                        'from' => 'custody',
                        'employee_id' => $emp->id,
                        'safe_id' => null,
                        'added_by' => User::first()->id,
                    ]);
                }
                // safe
                for ($z = 0; $z < 2; $z++) {
                    $safe = Safe::create([
                        'name' => 'safe ' . ($z + 1),
                        'added_by' => User::first()->id,
                    ]);
                    for ($u = 0; $u < 2; $u++) {
                        FinancialTransaction::create([
                            'type' => $type[array_rand($type)],
                            'description' => 'description ' . ($u + 1),
                            'amount' => rand(100, 1000),
                            'party_id' => null,
                            'financial_transaction_type_id' => $ft->id,
                            'from' => 'safe',
                            'employee_id' => null,
                            'safe_id' => $safe->id,
                            'added_by' => User::first()->id,
                        ]);
                    }
                }
            }
        }

        // client
        for ($i = 0; $i < 100; $i++) {
            Client::create([
                'name' => 'Client ' . ($i + 1),
                'phone' => '0123456789',
                'added_by' => User::first()->id,
            ]);
            // party and bill
        }
    }
}
