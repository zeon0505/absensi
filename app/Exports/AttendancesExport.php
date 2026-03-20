<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dateFrom;
    protected $dateTo;
    protected $status;
    protected $classroomId;

    public function __construct($dateFrom, $dateTo, $status, $classroomId = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->status = $status;
        $this->classroomId = $classroomId;
    }

    public function collection()
    {
        return Attendance::with(['user', 'classroom'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('date', '<=', $this->dateTo);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->classroomId, function ($query) {
                $query->where('classroom_id', $this->classroomId);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Kelas',
            'Tanggal',
            'Check In',
            'Check Out',
            'Status',
            'Latitude',
            'Longitude',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->user->name,
            $attendance->classroom->name ?? 'N/A',
            $attendance->date,
            $attendance->check_in,
            $attendance->check_out,
            $attendance->status,
            $attendance->latitude,
            $attendance->longitude,
        ];
    }
}
