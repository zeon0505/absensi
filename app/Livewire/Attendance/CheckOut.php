<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;
use Carbon\Carbon;

class CheckOut extends Component
{
    public function checkOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', Carbon::today()->toDateString())
            ->whereNull('check_out')
            ->first();

        if ($attendance) {
            $now = Carbon::now();
            $attendance->update([
                'check_out' => $now->toTimeString(),
            ]);
            
            auth()->user()->notify(new \App\Notifications\AttendanceNotification("Anda berhasil melakukan check-out pada pukul {$now->format('H:i:s')}."));

            session()->flash('message', 'Berhasil check-out!');
        } else {
            session()->flash('error', 'Anda belum check-in hari ini atau sudah check-out.');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.attendance.check-out');
    }
}
