<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run()
    {
        // Buat user baru atau ambil user yang sudah ada
        $user = User::firstOrCreate(
            ['email' => 'staff_jabar@gmail.com'],
            [
                'name' => 'Staff_Jabar',
                'password' => Hash::make('0987654321'),
                'no_hp' => '08561409895',
                'role' => 'staff'
            ]
        );

    }
}
