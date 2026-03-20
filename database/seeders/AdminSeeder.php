<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin (Global)
        User::updateOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Super Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Class Admin 1
        $admin1 = User::updateOrCreate(['email' => 'admin1@gmail.com'], [
            'name' => 'Admin Kelas A',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. Class Admin 2
        $admin2 = User::updateOrCreate(['email' => 'admin2@gmail.com'], [
            'name' => 'Admin Kelas B',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 4. Regular Users (Students)
        User::updateOrCreate(['email' => 'user@gmail.com'], [
            'name' => 'Siswa Contoh',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Sample Classrooms and assign admins
        $classA = Classroom::updateOrCreate(['name' => 'Kelas X - IPA 1'], [
            'description' => 'Ruang kelas untuk jurusan IPA angkatan 1',
            'enroll_code' => 'IPA101',
            'admin_id' => $admin1->id,
        ]);

        $classB = Classroom::updateOrCreate(['name' => 'Kelas X - IPS 1'], [
            'description' => 'Ruang kelas untuk jurusan IPS angkatan 1',
            'enroll_code' => 'IPS101',
            'admin_id' => $admin2->id,
        ]);
    }
}
