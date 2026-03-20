<?php

namespace App\Livewire\QR;

use App\Models\Attendance;
use App\Models\QrCode as QrCodeModel;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScanQR extends Component
{
    public $scanResult;

    // Remove the staff-generated code since the user will now be scanning
    public function mount()
    {
        $this->scanResult = null;
    }

    protected $listeners = ['processQrCode'];

    public function processQrCode($code)
    {
        $this->scanResult = $code;
        
        // Find valid QR Code from Admin in the database with classroom membership check
        $validQr = \App\Models\QrCode::where('code', $code)
            ->where('expired_at', '>=', Carbon::now())
            ->first();

        if (!$validQr) {
            $this->dispatch('qrError', 'QR Code tidak valid atau sudah kadaluarsa.');
            return;
        }

        // Verify user is a member of this classroom and is APPROVED
        $isMember = DB::table('classroom_user')
            ->where('user_id', auth()->id())
            ->where('classroom_id', $validQr->classroom_id)
            ->where('status', 'approved')
            ->exists();

        if (!$isMember) {
            $this->dispatch('qrError', 'Anda tidak terdaftar atau belum disetujui di kelas pembuat QR ini.');
            return;
        }

        $now = Carbon::now();
        $startTime = Carbon::createFromTimeString('08:15:00'); // Tolerance until 08:15
        $status = 'hadir';
        
        if ($now->greaterThan($startTime)) {
            $status = 'terlambat';
        }
        
        // Check if already checked in today
        $existing = Attendance::where('user_id', auth()->id())
            ->whereDate('date', $now->toDateString())
            ->first();
            
        if ($existing) {
            // Check out logic
            if (!$existing->check_out) {
                $existing->update([
                    'check_out' => $now->toTimeString(),
                ]);
                $this->dispatch('qrSuccess', 'Berhasil check-out pada pukul ' . $now->format('H:i'));
            } else {
                $this->dispatch('qrError', 'Anda sudah melakukan check-in dan check-out hari ini.');
            }
        } else {
            // Check in logic
            Attendance::create([
                'user_id' => auth()->id(),
                'classroom_id' => $validQr->classroom_id,
                'date' => $now->toDateString(),
                'check_in' => $now->toTimeString(),
                'status' => $status,
            ]);

            // Notify user
            try {
                auth()->user()->notify(new \App\Notifications\AttendanceNotification("Check-in berhasil via QR Scan pada " . $now->format('H:i')));
            } catch (\Exception $e) {
                // Ignore notification errors
            }

            $this->dispatch('qrSuccess', 'Absensi Berhasil! Status: ' . ucfirst($status));
        }
    }

    public function render()
    {
        return view('livewire.qr.scan-q-r');
    }
}
