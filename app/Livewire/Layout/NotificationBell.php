<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount;
    public $notifications;

    public function mount()
    {
        if (Auth::check()) {
            $this->notifications = Auth::user()->unreadNotifications()->limit(5)->get();
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function markAsRead($notificationId)
    {
        Auth::user()->notifications()->where("id", $notificationId)->first()->markAsRead();
        $this->mount(); // Refresh notifications
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->mount(); // Refresh notifications
    }

    public function render()
    {
        return view("livewire.layout.notification-bell");
    }
}

