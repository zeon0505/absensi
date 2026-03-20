<?php

namespace App\Livewire\Admin;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveManagement extends Component
{
    use WithPagination;

    public function approve($id)
    {
        $leave = Leave::find($id);
        $leave->update(['status' => 'approved']);
        
        $leave->user->notify(new \App\Notifications\LeaveStatusNotification('approved', $leave->type));
        
        session()->flash('message', 'Permintaan izin disetujui.');
    }

    public function reject($id)
    {
        $leave = Leave::find($id);
        $leave->update(['status' => 'rejected']);
        
        $leave->user->notify(new \App\Notifications\LeaveStatusNotification('rejected', $leave->type));
        
        session()->flash('message', 'Permintaan izin ditolak.');
    }

    public function render()
    {
        $user = auth()->user();
        $managedClassIds = $user->managedClassrooms()->pluck('id')->toArray();
        $isGlobalAdmin = empty($managedClassIds);

        $leaves = Leave::with(['user.classrooms'])
            ->when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
                $q->whereHas('user.classrooms', fn($sq) => $sq->whereIn('classroom_id', $managedClassIds));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.leave-management', compact('leaves'))
            ->layout('layouts.admin');
    }
}
