<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceReport extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $status = '';
    public $selectedClassId = '';

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $managedClassIds = $user->managedClassrooms()->pluck('id')->toArray();
        $isGlobalAdmin = empty($managedClassIds);

        $attendances = Attendance::with(['user', 'classroom'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('date', '<=', $this->dateTo);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->selectedClassId, function ($query) {
                $query->where('classroom_id', $this->selectedClassId);
            })
            ->when(!$isGlobalAdmin, function($query) use ($managedClassIds) {
                $query->whereIn('classroom_id', $managedClassIds);
            })
            ->latest('date')
            ->paginate(15);

        $classrooms = \App\Models\Classroom::when(!$isGlobalAdmin, function($q) use ($managedClassIds) {
            $q->whereIn('id', $managedClassIds);
        })->get();

        return view('livewire.admin.attendance-report', compact('attendances', 'classrooms'))
            ->layout('layouts.admin');
    }

    public function exportPdf()
    {
        $attendances = Attendance::with(['user', 'classroom'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('date', '<=', $this->dateTo);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->selectedClassId, function ($query) {
                $query->where('classroom_id', $this->selectedClassId);
            })
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.attendances', compact('attendances'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-absensi.pdf');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendancesExport($this->dateFrom, $this->dateTo, $this->status, $this->selectedClassId),
            'laporan-absensi.xlsx'
        );
    }
}
