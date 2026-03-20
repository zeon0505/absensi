<?php

namespace App\Livewire\User;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Leave;
use App\Models\TaskSubmission;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public $joinCode = '';
    public $showSubmitModal = false;
    public $taskTitle, $taskDescription, $taskFile, $selectedClassId;
    public $message = '';

    public function joinClass()
    {
        $this->validate([
            'joinCode' => 'required',
        ]);

        $classroom = Classroom::where('enroll_code', $this->joinCode)->first();

        if (!$classroom) {
            session()->flash('error', 'Kode enroll tidak valid.');
            return;
        }

        $user = Auth::user();
        if ($user->classrooms()->where('classroom_id', $classroom->id)->exists()) {
            session()->flash('error', 'Anda sudah terdaftar atau sedang dalam antrean kelas ini.');
            return;
        }

        $user->classrooms()->attach($classroom->id, ['status' => 'pending']);
        $this->joinCode = '';
        session()->flash('message', 'Permintaan bergabung ke ' . $classroom->name . ' telah dikirim. Menunggu persetujuan admin.');
    }

    public function openSubmitModal($classId)
    {
        $this->selectedClassId = $classId;
        $this->showSubmitModal = true;
    }

    public function submitTask()
    {
        $this->validate([
            'taskTitle' => 'required|min:3',
            'taskFile' => 'required|max:5120', // 5MB max
            'selectedClassId' => 'required|exists:classrooms,id',
        ]);

        $isMember = Auth::user()->classrooms()
            ->where('classroom_id', $this->selectedClassId)
            ->wherePivot('status', 'approved')
            ->exists();

        if (!$isMember) {
            session()->flash('error', 'Anda harus disetujui sebagai anggota kelas untuk mengirim tugas.');
            return;
        }

        $path = $this->taskFile->store('tasks', 'public');

        TaskSubmission::create([
            'user_id' => Auth::id(),
            'classroom_id' => $this->selectedClassId,
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'file_path' => $path,
            'status' => 'submitted',
        ]);

        session()->flash('message', 'Tugas berhasil dikirim!');
        $this->showSubmitModal = false;
        $this->reset(['taskTitle', 'taskDescription', 'taskFile', 'selectedClassId']);
    }

    public function leaveClass($classId)
    {
        Auth::user()->classrooms()->detach($classId);
        session()->flash('message', 'Berhasil keluar dari kelas.');
    }

    public function render()
    {
        $user = Auth::user();
        
        $stats = [
            'presence_count' => Attendance::where('user_id', $user->id)->where('status', 'hadir')->count(),
            'late_count' => Attendance::where('user_id', $user->id)->where('status', 'terlambat')->count(),
            'leave_count' => Leave::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending_leave' => Leave::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        $myClassrooms = $user->classrooms()->with(['admin'])->withPivot('status')->get();
        // $allClassrooms no longer needed as we use manual code entry
        
        $recentHistory = Attendance::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $myTasks = TaskSubmission::where('user_id', $user->id)
            ->with('classroom')
            ->latest()
            ->get();

        return view('livewire.user.dashboard', [
            'stats' => $stats,
            'myClassrooms' => $myClassrooms,
            'recentHistory' => $recentHistory,
            'myTasks' => $myTasks,
        ])->layout('layouts.app');
    }
}
