<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuperAdmin::create([
            'name' => 'Halla Shammout',
            'email' => 'Halla@gmail.com',
            'username' => 'h5_ar',
            'password' => Hash::make('123456789'),
        ]);
    }
}
