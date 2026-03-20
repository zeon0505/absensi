<?php

namespace App\Livewire\User;

use Livewire\Component;

class Notifications extends Component
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('livewire.user.notifications', compact('notifications'))
            ->layout('layouts.app');
    }
}
