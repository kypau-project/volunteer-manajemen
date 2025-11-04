<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationStatusNotification extends Notification
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->registration->status;
        $title = $status == 'approved' ? 'Pendaftaran Disetujui' : 'Pendaftaran Ditolak';
        $body = $status == 'approved' 
            ? 'Selamat! Pendaftaran Anda ke acara ' . $this->registration->event->title . ' telah disetujui.'
            : 'Mohon maaf, pendaftaran Anda ke acara ' . $this->registration->event->title . ' telah ditolak.';

        return [
            'title' => $title,
            'body' => $body,
            'url' => route('volunteer.dashboard'),
        ];
    }
}

