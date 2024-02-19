<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '010XXXXXXXX',
            'added_by' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole('super_admin');
    }
}
