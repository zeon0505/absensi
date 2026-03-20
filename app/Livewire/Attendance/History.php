<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class History extends Component
{
    public function render()
    {
        $attendances = Attendance::with('classroom')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.attendance.history', compact('attendances'));
    }
}
