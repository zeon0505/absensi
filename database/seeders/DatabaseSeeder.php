<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@absensi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Sample Karyawan
        User::create([
            'name' => 'John Doe',
            'email' => 'john@absensi.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@absensi.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->call(AttendanceSeeder::class);
    }
}
