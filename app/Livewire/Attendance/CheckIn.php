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
    public $selectedClassId;
    public $step = 1; // 1: Select Class, 2: GPS Check-in

    protected $listeners = ['updateLocation'];

    public function selectClass($id)
    {
        $this->selectedClassId = $id;
        $this->step = 2;
    }

    public function updateLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function checkIn()
    {
        if (!$this->selectedClassId) {
            session()->flash('error', 'Silakan pilih kelas terlebih dahulu.');
            return;
        }

        $now = Carbon::now();
        $startTime = Carbon::createFromTimeString('08:00:00');
        
        if ($now->greaterThan($startTime)) {
            $this->status = 'terlambat';
        }

        Attendance::create([
            'user_id' => auth()->id(),
            'classroom_id' => $this->selectedClassId,
            'date' => $now->toDateString(),
            'check_in' => $now->toTimeString(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
        ]);

        auth()->user()->notify(new \App\Notifications\AttendanceNotification("Anda berhasil melakukan check-in GPS pada pukul {$now->format('H:i:s')}."));

        session()->flash('message', 'Berhasil check-in!');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $classrooms = auth()->user()->classrooms()->wherePivot('status', 'approved')->get();
        return view('livewire.attendance.check-in', compact('classrooms'));
    }
}
