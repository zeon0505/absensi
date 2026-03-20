<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;
use Carbon\Carbon;

class CheckIn extends Component
{
    public $latitude;
    public $longitude;
    public $status = 'hadir';

    protected $listeners = ['updateLocation'];

    public function updateLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function checkIn()
    {
        $now = Carbon::now();
        $startTime = Carbon::createFromTimeString('08:00:00');
        
        if ($now->greaterThan($startTime)) {
            $this->status = 'terlambat';
        }

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $now->toDateString(),
            'check_in' => $now->toTimeString(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
        ]);

        auth()->user()->notify(new \App\Notifications\AttendanceNotification("Anda berhasil melakukan check-in pada pukul {$now->format('H:i:s')}."));

        session()->flash('message', 'Berhasil check-in!');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.attendance.check-in');
    }
}
