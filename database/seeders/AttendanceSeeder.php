<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $now = Carbon::now();

        foreach ($users as $user) {
            for ($i = 6; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                
                // Skip weekends (optional, but realistic)
                if ($date->isWeekend()) continue;

                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $date->toDateString(),
                    'check_in' => '07:' . rand(45, 59) . ':00',
                    'check_out' => '17:00:00',
                    'status' => 'hadir',
                    'latitude' => '-6.2088',
                    'longitude' => '106.8456',
                ]);
            }
        }
    }
}
