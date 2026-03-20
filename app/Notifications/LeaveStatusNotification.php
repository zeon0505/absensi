<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeaveStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $leaveType;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $leaveType)
    {
        $this->status = $status;
        $this->leaveType = $leaveType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = "Pengajuan {$this->leaveType} Anda telah " . ($this->status === 'approved' ? 'disetujui' : 'ditolak') . ".";
        
        return [
            'message' => $message,
            'status' => $this->status,
        ];
    }
}
