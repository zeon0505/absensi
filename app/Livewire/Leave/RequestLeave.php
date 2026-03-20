<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use Livewire\Component;

class RequestLeave extends Component
{
    public $type = 'izin';
    public $reason;
    public $start_date;
    public $end_date;

    protected $rules = [
        'type' => 'required|string',
        'reason' => 'required|string|min:10',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    public function submit()
    {
        $this->validate();

        Leave::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'reason' => $this->reason,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Permintaan izin berhasil dikirim.');
        return redirect()->route('leave.list');
    }

    public function render()
    {
        return view('livewire.leave.request-leave');
    }
}
