<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer
        $customerUser = User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@mail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        Customer::create([
            'user_id' => $customerUser->id,
            'phone' => '08123456789',
            'address' => 'Alamat Customer Demo',
        ]);
    }
}
