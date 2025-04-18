<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactNotify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $contact;
    public function __construct($contact)
    {
        //
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
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

    public function toArray(object $notifiable): array
    {
        return [
            'contact_title' => $this->contact->title,
            'contact_id' => $this->contact->id,
            'user_name' => $this->contact->name,
            'link' => route('admin.contacts.show', $this->contact->id)
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'contact_title' => $this->contact->title,
            'contact_id' => $this->contact->id,
            'user_name' => $this->contact->name,
            'link' => route('admin.contacts.show', $this->contact->id)
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'contact_title' => $this->contact->title,
            'contact_id' => $this->contact->id,
            'user_name' => $this->contact->name,
            'link' => route('admin.contacts.show', $this->contact->id)
        ];
    }

    public function databaseType(): string
    {
        return 'NewContactNotify';
    }
}
