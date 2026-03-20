<?php

namespace App\Livewire\QR;

use Livewire\Component;
use App\Models\QrCode as QrCodeModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQR extends Component
{
    public ?string $qrCode = null;
    public ?string $qrExpiredAt = null;
    public ?string $qrCreatedAt = null;
    public ?string $qrSvg = null;
    public ?int $selectedClassId = null;

    public function mount()
    {
        // Try to get the first classroom managed by this admin
        $firstClass = \App\Models\Classroom::where('admin_id', auth()->id())->first();
        if ($firstClass) {
            $this->selectedClassId = $firstClass->id;
            $this->loadCurrentQrCode();
        }
    }

    public function updatedSelectedClassId()
    {
        $this->loadCurrentQrCode();
    }

    public function loadCurrentQrCode()
    {
        if (!$this->selectedClassId) {
            $this->resetStates();
            return;
        }

        $qr = QrCodeModel::where('classroom_id', $this->selectedClassId)
            ->where('expired_at', '>=', Carbon::now())
            ->latest()
            ->first();

        if ($qr) {
            $this->qrCode = $qr->code;
            $this->qrExpiredAt = Carbon::parse($qr->expired_at)->format('d M Y - H:i');
            $this->qrCreatedAt = Carbon::parse($qr->created_at)->format('d M Y - H:i');
            // Explicitly call format('svg') to be safe
            $this->qrSvg = QrCode::size(300)->format('svg')->generate($qr->code);
        } else {
            $this->resetStates();
        }
    }

    private function resetStates()
    {
        $this->qrCode = null;
        $this->qrExpiredAt = null;
        $this->qrCreatedAt = null;
        $this->qrSvg = null;
    }

    public function generateNewQr()
    {
        try {
            if (!$this->selectedClassId) {
                session()->flash('error', 'Pilih kelas terlebih dahulu.');
                return;
            }

            // Expire old active QR codes for THIS classroom
            QrCodeModel::where('classroom_id', $this->selectedClassId)
                ->where('expired_at', '>=', Carbon::now())
                ->update(['expired_at' => Carbon::now()->subSecond()]);

            // Create new QR Code string
            $codeString = 'ABSENSI-' . $this->selectedClassId . '-' . date('Ymd') . '-' . strtoupper(Str::random(10));

            // Valid for 24 hours
            $expires = Carbon::now()->addHours(24);

            $qr = QrCodeModel::create([
                'code' => $codeString,
                'expired_at' => $expires,
                'classroom_id' => $this->selectedClassId
            ]);

            $this->qrCode = $qr->code;
            $this->qrExpiredAt = Carbon::parse($qr->expired_at)->format('d M Y - H:i');
            $this->qrCreatedAt = Carbon::parse($qr->created_at)->format('d M Y - H:i');
            $this->qrSvg = QrCode::size(300)->format('svg')->generate($codeString);

            session()->flash('message', 'QR Code baru berhasil diaktifkan.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal generate QR: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $classrooms = \App\Models\Classroom::where('admin_id', auth()->id())->get();

        return view('livewire.qr.generate-q-r', compact('classrooms'))->layout('layouts.admin');
    }
}
