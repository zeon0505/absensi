<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use Livewire\Component;

class LeaveList extends Component
{
    public function render()
    {
        $leaves = Leave::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.leave.leave-list', compact('leaves'));
    }
}
